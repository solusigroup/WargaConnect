<?php

namespace App\Http\Controllers;

use App\Models\Complaint;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class ComplaintController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        if (strtolower(Auth::user()->role) === 'admin') {
            $complaints = Complaint::with('user')->latest()->paginate(10);
        } else {
            $complaints = Auth::user()->complaints()->latest()->paginate(10);
        }

        return view('complaints.index', compact('complaints'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('complaints.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'required|string',
            'image' => 'nullable|image|max:2048', // 2MB Max
        ]);

        $data = $request->only(['title', 'description']);
        $data['user_id'] = Auth::id();
        $data['status'] = 'pending';

        if ($request->hasFile('image')) {
            $path = $request->file('image')->store('complaints', 'public');
            $data['image'] = $path;
        }

        Complaint::create($data);

        return redirect()->route('complaints.index')->with('success', 'Aduan berhasil dikirim.');
    }

    /**
     * Display the specified resource.
     */
    public function show(Complaint $complaint)
    {
        // Authorization check: Admin or Owner
        if (strtolower(Auth::user()->role) !== 'admin' && $complaint->user_id !== Auth::id()) {
            abort(403);
        }

        return view('complaints.show', compact('complaint'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Complaint $complaint)
    {
        // Only Admin can update status
        if (strtolower(Auth::user()->role) !== 'admin') {
            abort(403);
        }

        $request->validate([
            'status' => 'required|in:pending,processed,resolved,rejected',
        ]);

        $complaint->update(['status' => $request->status]);

        return back()->with('success', 'Status aduan diperbarui.');
    }
}
