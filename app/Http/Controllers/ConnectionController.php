<?php

namespace App\Http\Controllers;

use App\Models\Connections;
use App\Models\Job_offers;
use App\Models\Posts;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ConnectionController extends Controller

{
    public function dashboard()
    {
        $receivedConnections = Connections::where('target_user_id', Auth::id())
         ->where('status', 'pending')
        ->get();
        
        $posts = Posts::all();
        $users = User::where('id', '!=', Auth::id())->get()->sortBy('created_at');
        $jobs =  Job_offers::all();


        return view('dashboard', compact('receivedConnections','posts','users','jobs'));
    }
    public function sendRequest(Request $request)
    {
        $request->validate([
            'target_user_id' => 'required|exists:users,id',
        ]);

        $connection = new Connections();
        $connection->source_user_id = Auth::id();
        $connection->target_user_id = $request->input('target_user_id');
        $connection->status = 'pending';
        $connection->request_date = now();
        // dd($connection);
        $connection->save();

        return back()->with('status', 'Connection request sent.');
    }

    public function acceptRequest(Request $request)
    {
        $request->validate([
            'connection_id' => 'required|exists:connections,id',
        ]);

        $connection = Connections::find($request->input('connection_id'));
        if ($connection->target_user_id != Auth::id()) {
            return back()->withErrors(['error' => 'Unauthorized action.']);
        }

        $connection->status = 'accepted';
        $connection->save();

        return back()->with('status', 'Connection request accepted.');
    }

    public function rejectRequest(Request $request)
    {
        $request->validate([
            'connection_id' => 'required|exists:connections,id',
        ]);

        $connection = Connections::find($request->input('connection_id'));
        if ($connection->target_user_id != Auth::id()) {
            return back()->withErrors(['error' => 'Unauthorized action.']);
        }

        $connection->status = 'rejected';
        $connection->save();

        return back()->with('status', 'Connection request rejected.');
    }
}