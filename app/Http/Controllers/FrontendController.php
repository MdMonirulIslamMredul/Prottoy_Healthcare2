<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\NewsEvent;
use App\Models\Notice;

class FrontendController extends Controller
{
    public function home()
    {
        return view('frontend.home');
    }

    public function about()
    {
        return view('frontend.about');
    }

    public function organisation()
    {
        return view('frontend.organisation');
    }

    public function policy()
    {
        return view('frontend.policy');
    }

    public function customerService()
    {
        return view('frontend.customer-service');
    }

    public function gallery()
    {
        return view('frontend.gallery');
    }

    public function newsEvents(Request $request)
    {
        $query = NewsEvent::active();

        // Search by title or content
        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function($q) use ($search) {
                $q->where('title', 'like', '%' . $search . '%')
                  ->orWhere('content', 'like', '%' . $search . '%');
            });
        }

        // Filter by date range
        if ($request->filled('date_from')) {
            $query->whereDate('published_at', '>=', $request->date_from);
        }

        if ($request->filled('date_to')) {
            $query->whereDate('published_at', '<=', $request->date_to);
        }

        $newsEvents = $query->orderBy('published_at', 'desc')->paginate(12)->withQueryString();
        return view('frontend.news-events', compact('newsEvents'));
    }

    public function newsEventShow($id)
    {
        $newsEvent = NewsEvent::active()->findOrFail($id);
        return view('frontend.news-event-detail', compact('newsEvent'));
    }

    public function notices(Request $request)
    {
        $query = Notice::active();

        // Search by title or content
        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function($q) use ($search) {
                $q->where('title', 'like', '%' . $search . '%')
                  ->orWhere('content', 'like', '%' . $search . '%')
                  ->orWhere('details', 'like', '%' . $search . '%');
            });
        }

        // Filter by type
        if ($request->filled('type')) {
            $query->where('type', $request->type);
        }

        // Filter by date range
        if ($request->filled('date_from')) {
            $query->whereDate('published_at', '>=', $request->date_from);
        }

        if ($request->filled('date_to')) {
            $query->whereDate('published_at', '<=', $request->date_to);
        }

        $notices = $query->orderBy('published_at', 'desc')->paginate(15)->withQueryString();
        return view('frontend.notices', compact('notices'));
    }

    public function noticeShow($id)
    {
        $notice = Notice::active()->findOrFail($id);
        return view('frontend.notice-detail', compact('notice'));
    }
}
