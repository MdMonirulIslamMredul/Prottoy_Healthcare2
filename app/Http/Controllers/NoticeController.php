<?php

namespace App\Http\Controllers;

use App\Models\Notice;
use Illuminate\Http\Request;
use Carbon\Carbon;

class NoticeController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $notices = Notice::orderBy('published_at', 'desc')->paginate(15);
        return view('backend.superadmin.notices.index', compact('notices'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('backend.superadmin.notices.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'content' => 'required|string',
            'type' => 'required|in:general,emergency,announcement,event',
            'is_active' => 'boolean',
            'published_at' => 'nullable|date',
        ]);

        // Set default published_at to now if not provided
        if (!isset($validated['published_at'])) {
            $validated['published_at'] = Carbon::now();
        }

        // Handle is_active checkbox
        $validated['is_active'] = $request->has('is_active') ? true : false;

        Notice::create($validated);

        return redirect()->route('superadmin.notices.index')
            ->with('success', 'Notice created successfully.');
    }

    /**
     * Display the specified resource.
     */
    public function show(Notice $notice)
    {
        return view('backend.superadmin.notices.show', compact('notice'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Notice $notice)
    {
        return view('backend.superadmin.notices.edit', compact('notice'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Notice $notice)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'content' => 'required|string',
            'type' => 'required|in:general,emergency,announcement,event',
            'is_active' => 'boolean',
            'published_at' => 'nullable|date',
        ]);

        // Handle is_active checkbox
        $validated['is_active'] = $request->has('is_active') ? true : false;

        $notice->update($validated);

        return redirect()->route('superadmin.notices.index')
            ->with('success', 'Notice updated successfully.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Notice $notice)
    {
        $notice->delete();

        return redirect()->route('superadmin.notices.index')
            ->with('success', 'Notice deleted successfully.');
    }

    /**
     * Toggle notice active status
     */
    public function toggleStatus(Notice $notice)
    {
        $notice->update(['is_active' => !$notice->is_active]);

        return redirect()->route('superadmin.notices.index')
            ->with('success', 'Notice status updated successfully.');
    }
}
