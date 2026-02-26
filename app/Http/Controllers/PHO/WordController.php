<?php

namespace App\Http\Controllers\PHO;

use App\Http\Controllers\Controller;
use App\Models\Union;
use App\Models\Word;
use Illuminate\Http\Request;

class WordController extends Controller
{
    public function index()
    {
        $pho = auth()->user();

        $unionIds = $pho->upzila ? $pho->upzila->unions->pluck('id')->toArray() : [];

        $words = Word::whereIn('union_id', $unionIds)
            ->with('union')
            ->latest()
            ->paginate(15);

        return view('backend.pho.words.index', compact('words'));
    }

    public function create()
    {
        $pho = auth()->user();

        $unions = $pho->upzila ? $pho->upzila->unions : collect();

        return view('backend.pho.words.create', compact('unions', 'pho'));
    }

    public function store(Request $request)
    {
        $pho = auth()->user();

        $validated = $request->validate([
            'union_id' => ['required', 'exists:unions,id'],
            'name' => ['required', 'string', 'max:255'],
            'bn_name' => ['nullable', 'string', 'max:255'],
        ]);

        // Ensure the selected union belongs to PHO's upzila (use relation to avoid column-name typos)
        $union = Union::with('upazila')->find($validated['union_id']);
        if (!$union || !$union->upazila || $union->upazila->id !== $pho->upzila_id) {
            abort(403, 'Unauthorized union selection.');
        }

        Word::create([
            'union_id' => $validated['union_id'],
            'name' => $validated['name'],
            'bn_name' => $validated['bn_name'] ?? null,
        ]);

        return redirect()->route('pho.words.index')->with('success', 'Word created successfully.');
    }

    /**
     * AJAX: return words for a given union id
     */
    public function getWords($unionId)
    {
        $words = Word::where('union_id', $unionId)->orderBy('name')->get(['id', 'name', 'bn_name']);
        return response()->json(['words' => $words]);
    }

    /**
     * Show the form for editing the specified word.
     */
    public function edit(Word $word)
    {
        $pho = auth()->user();

        // Authorization: word's union must belong to PHO upzila
        $word->load('union.upazila');
        if (!$word->union || !$word->union->upazila || $word->union->upazila->id !== $pho->upzila_id) {
            abort(403, 'Unauthorized action.');
        }

        $unions = $pho->upzila ? $pho->upzila->unions : collect();

        return view('backend.pho.words.edit', compact('word', 'unions'));
    }

    /**
     * Update the specified word in storage.
     */
    public function update(Request $request, Word $word)
    {
        $pho = auth()->user();

        $validated = $request->validate([
            'union_id' => ['required', 'exists:unions,id'],
            'name' => ['required', 'string', 'max:255'],
            'bn_name' => ['nullable', 'string', 'max:255'],
        ]);

        $union = Union::with('upazila')->find($validated['union_id']);
        if (!$union || !$union->upazila || $union->upazila->id !== $pho->upzila_id) {
            abort(403, 'Unauthorized union selection.');
        }

        $word->update([
            'union_id' => $validated['union_id'],
            'name' => $validated['name'],
            'bn_name' => $validated['bn_name'] ?? null,
        ]);

        return redirect()->route('pho.words.index')->with('success', 'Word updated successfully.');
    }

    /**
     * Remove the specified word from storage.
     */
    public function destroy(Word $word)
    {
        $pho = auth()->user();

        $word->load('union.upazila');
        if (!$word->union || !$word->union->upazila || $word->union->upazila->id !== $pho->upzila_id) {
            abort(403, 'Unauthorized action.');
        }

        $word->delete();

        return redirect()->route('pho.words.index')->with('success', 'Word deleted successfully.');
    }
}
