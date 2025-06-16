<?php
namespace App\Http\Controllers;

use App\Models\Member;
use Illuminate\Http\Request;

class MembershipController extends Controller
{
    public function join()
    {
        return view('membership.join');
    }
    
    public function store(Request $request)
    {
        $validated = $request->validate([
            'first_name' => 'required|string|max:255',
            'last_name' => 'required|string|max:255',
            'email' => 'required|email|unique:members',
            'phone' => 'required|string',
            'bio' => 'nullable|string',
        ]);
        
        $validated['joined_date'] = now();
        $validated['is_board_member'] = false;
        
        Member::create($validated);
        
        return redirect()->route('membership.join')
            ->with('success', 'Votre demande d\'adhésion a été envoyée!');
    }
}