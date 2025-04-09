<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;

class LeaderboardController extends Controller
{
    public function recalculateLeaderboard(Request $request)
    {

        User::query()->update(['total_points' => 0]);
  
        $users = User::with('activities')->get();

        foreach ($users as $user) {
            $points = $user->activities->count() * 20;

            $user->update(['total_points' => $points]);
        }
    

        $sorted = User::orderByDesc('total_points')->get();
        $rank = 1;
        $prevPoints = null;
        $currentRank = 1;
        
        foreach ($sorted as $user) {
            if ($prevPoints !== null && $user->total_points < $prevPoints) {
                $rank = $currentRank;
            }
        
            $user->update(['rank' => $rank]);
            $prevPoints = $user->total_points;
            $currentRank++;
        }
    
        return back()->with('success', 'Leaderboard recalculated');
    }
    
    public function index(Request $request)
    {
        $query = User::query();
    
        if ($request->filled('filter')) {
            $now = now();
            $filter = $request->filter;
    
            $query->whereHas('activities', function ($query) use ($filter, $now) {
                if ($filter === 'day') {
                    $query->whereDate('completed_at', $now->toDateString());
                } elseif ($filter === 'month') {
                    $query->whereMonth('completed_at', $now->month)->whereYear('completed_at', $now->year);
                } elseif ($filter === 'year') {
                    $query->whereYear('completed_at', $now->year);
                }
            });
        }
    
        if ($request->filled('user_id')) {
            $query->orderByRaw("id = ? DESC", [$request->user_id]);
        }
    
        $users = $query->orderBy('rank')->get();
    
        return view('leaderboard.index', compact('users'));
    }
}
