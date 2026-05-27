<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Agent;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;

class AgentVerificationController extends Controller
{
    // Daftar semua agen
    public function index(Request $request)
    {
        $status = $request->get('status', 'pending');
        $agents = Agent::when($status, function($query, $status) {
            return $query->where('status', $status);
        })->orderBy('created_at', 'desc')->paginate(20);
        
        return view('admin.agents.index', compact('agents', 'status'));
    }
    
    // Detail agen
    public function show($id)
    {
        $agent = Agent::findOrFail($id);
        return view('admin.agents.show', compact('agent'));
    }
    
    // Verifikasi / setujui agen
    public function verify($id)
    {
        $agent = Agent::findOrFail($id);
        $agent->status = 'active';
        $agent->verified_at = now();
        $agent->save();
        
        // Kirim email notifikasi
        // Mail::to($agent->email)->send(new AgentVerifiedMail($agent));
        
        return redirect()->route('admin.agents.index', ['status' => 'pending'])
            ->with('success', "Agen {$agent->agency_name} telah diverifikasi.");
    }
    
    // Tolak agen
    public function reject(Request $request, $id)
    {
        $request->validate([
            'reason' => 'required|string|min:10'
        ]);
        
        $agent = Agent::findOrFail($id);
        $agent->status = 'suspended';
        $agent->rejected_reason = $request->reason;
        $agent->save();
        
        // Kirim email penolakan
        // Mail::to($agent->email)->send(new AgentRejectedMail($agent, $request->reason));
        
        return redirect()->route('admin.agents.index', ['status' => 'pending'])
            ->with('success', "Agen {$agent->agency_name} telah ditolak.");
    }
    
    // Hapus agen
    public function destroy($id)
    {
        $agent = Agent::findOrFail($id);
        $agentName = $agent->agency_name;
        $agent->delete();
        
        return redirect()->route('admin.agents.index')
            ->with('success', "Agen {$agentName} telah dihapus.");
    }
    
    // Suspend / blokir agen
    public function suspend($id)
    {
        $agent = Agent::findOrFail($id);
        $agent->status = 'suspended';
        $agent->save();
        
        return redirect()->back()->with('success', "Agen {$agent->agency_name} telah ditangguhkan.");
    }
    
    // Aktifkan kembali agen
    public function activate($id)
    {
        $agent = Agent::findOrFail($id);
        $agent->status = 'active';
        $agent->save();
        
        return redirect()->back()->with('success', "Agen {$agent->agency_name} telah diaktifkan kembali.");
    }
}