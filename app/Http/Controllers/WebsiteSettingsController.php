<?php

namespace App\Http\Controllers;

use App\Models\Slider;
use App\Models\Service;
use App\Models\AboutContent;
use App\Models\Leadership;
use App\Models\Policy;
use App\Models\GalleryImage;
use App\Models\OrganizationalRole;
use App\Models\NewsEvent;
use App\Models\Notice;
use App\Models\ContactInfo;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class WebsiteSettingsController extends Controller
{
    // Slider Management
    public function sliders()
    {
        $sliders = Slider::orderBy('order')->paginate(10);
        return view('backend.superadmin.website.sliders.index', compact('sliders'));
    }

    public function createSlider()
    {
        return view('backend.superadmin.website.sliders.create');
    }

    public function storeSlider(Request $request)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'subtitle' => 'nullable|string',
            'image' => 'required|image|mimes:jpeg,png,jpg|max:2048',
            'button_text' => 'nullable|string|max:100',
            'button_link' => 'nullable|string|max:255',
            'order' => 'nullable|integer',
            'is_active' => 'boolean',
        ]);

        if ($request->hasFile('image')) {
            $validated['image'] = $request->file('image')->store('sliders', 'public');
        }

        $validated['is_active'] = $request->has('is_active');

        Slider::create($validated);

        return redirect()->route('superadmin.website.sliders.index')
            ->with('success', 'Slider created successfully.');
    }

    public function editSlider(Slider $slider)
    {
        return view('backend.superadmin.website.sliders.edit', compact('slider'));
    }

    public function updateSlider(Request $request, Slider $slider)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'subtitle' => 'nullable|string',
            'image' => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
            'button_text' => 'nullable|string|max:100',
            'button_link' => 'nullable|string|max:255',
            'order' => 'nullable|integer',
            'is_active' => 'boolean',
        ]);

        if ($request->hasFile('image')) {
            if ($slider->image) {
                Storage::disk('public')->delete($slider->image);
            }
            $validated['image'] = $request->file('image')->store('sliders', 'public');
        }

        $validated['is_active'] = $request->has('is_active');

        $slider->update($validated);

        return redirect()->route('superadmin.website.sliders.index')
            ->with('success', 'Slider updated successfully.');
    }

    public function destroySlider(Slider $slider)
    {
        if ($slider->image) {
            Storage::disk('public')->delete($slider->image);
        }
        $slider->delete();

        return redirect()->route('superadmin.website.sliders.index')
            ->with('success', 'Slider deleted successfully.');
    }

    // Services Management
    public function services()
    {
        $services = Service::orderBy('order')->paginate(10);
        return view('backend.superadmin.website.services.index', compact('services'));
    }

    public function createService()
    {
        return view('backend.superadmin.website.services.create');
    }

    public function storeService(Request $request)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'required|string',
            'icon' => 'nullable|string|max:100',
            'image' => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
            'order' => 'nullable|integer',
            'is_active' => 'boolean',
        ]);

        if ($request->hasFile('image')) {
            $validated['image'] = $request->file('image')->store('services', 'public');
        }

        $validated['is_active'] = $request->has('is_active');

        Service::create($validated);

        return redirect()->route('superadmin.website.services.index')
            ->with('success', 'Service created successfully.');
    }

    public function editService(Service $service)
    {
        return view('backend.superadmin.website.services.edit', compact('service'));
    }

    public function updateService(Request $request, Service $service)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'required|string',
            'icon' => 'nullable|string|max:100',
            'image' => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
            'order' => 'nullable|integer',
            'is_active' => 'boolean',
        ]);

        if ($request->hasFile('image')) {
            if ($service->image) {
                Storage::disk('public')->delete($service->image);
            }
            $validated['image'] = $request->file('image')->store('services', 'public');
        }

        $validated['is_active'] = $request->has('is_active');

        $service->update($validated);

        return redirect()->route('superadmin.website.services.index')
            ->with('success', 'Service updated successfully.');
    }

    public function destroyService(Service $service)
    {
        if ($service->image) {
            Storage::disk('public')->delete($service->image);
        }
        $service->delete();

        return redirect()->route('superadmin.website.services.index')
            ->with('success', 'Service deleted successfully.');
    }

    // About Content Management
    public function aboutContents()
    {
        $contents = AboutContent::orderBy('type')->paginate(10);
        return view('backend.superadmin.website.about.index', compact('contents'));
    }

    public function createAboutContent()
    {
        return view('backend.superadmin.website.about.create');
    }

    public function storeAboutContent(Request $request)
    {
        $validated = $request->validate([
            'type' => 'required|in:mission,vision,about',
            'title' => 'required|string|max:255',
            'content' => 'required|string',
            'image' => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
            'is_active' => 'boolean',
        ]);

        if ($request->hasFile('image')) {
            $validated['image'] = $request->file('image')->store('about', 'public');
        }

        $validated['is_active'] = $request->has('is_active');

        AboutContent::create($validated);

        return redirect()->route('superadmin.website.about.index')
            ->with('success', 'Content created successfully.');
    }

    public function editAboutContent(AboutContent $aboutContent)
    {
        return view('backend.superadmin.website.about.edit', compact('aboutContent'));
    }

    public function updateAboutContent(Request $request, AboutContent $aboutContent)
    {
        $validated = $request->validate([
            'type' => 'required|in:mission,vision,about',
            'title' => 'required|string|max:255',
            'content' => 'required|string',
            'image' => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
            'is_active' => 'boolean',
        ]);

        if ($request->hasFile('image')) {
            if ($aboutContent->image) {
                Storage::disk('public')->delete($aboutContent->image);
            }
            $validated['image'] = $request->file('image')->store('about', 'public');
        }

        $validated['is_active'] = $request->has('is_active');

        $aboutContent->update($validated);

        return redirect()->route('superadmin.website.about.index')
            ->with('success', 'Content updated successfully.');
    }

    public function destroyAboutContent(AboutContent $aboutContent)
    {
        if ($aboutContent->image) {
            Storage::disk('public')->delete($aboutContent->image);
        }
        $aboutContent->delete();

        return redirect()->route('superadmin.website.about.index')
            ->with('success', 'Content deleted successfully.');
    }

    // Leadership Management
    public function leaderships()
    {
        $leaderships = Leadership::orderBy('order')->paginate(10);
        return view('backend.superadmin.website.leadership.index', compact('leaderships'));
    }

    public function createLeadership()
    {
        return view('backend.superadmin.website.leadership.create');
    }

    public function storeLeadership(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'designation' => 'required|string|max:255',
            'bio' => 'nullable|string',
            'photo' => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
            'email' => 'nullable|email|max:255',
            'phone' => 'nullable|string|max:20',
            'order' => 'nullable|integer',
        ]);

        if ($request->hasFile('photo')) {
            $validated['photo'] = $request->file('photo')->store('leadership', 'public');
        }

        $validated['is_active'] = $request->has('is_active');

        Leadership::create($validated);

        return redirect()->route('superadmin.website.leadership.index')
            ->with('success', 'Leadership created successfully.');
    }

    public function editLeadership(Leadership $leadership)
    {
        return view('backend.superadmin.website.leadership.edit', compact('leadership'));
    }

    public function updateLeadership(Request $request, Leadership $leadership)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'designation' => 'required|string|max:255',
            'bio' => 'nullable|string',
            'photo' => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
            'email' => 'nullable|email|max:255',
            'phone' => 'nullable|string|max:20',
            'order' => 'nullable|integer',
        ]);

        if ($request->hasFile('photo')) {
            if ($leadership->photo) {
                Storage::disk('public')->delete($leadership->photo);
            }
            $validated['photo'] = $request->file('photo')->store('leadership', 'public');
        }

        $validated['is_active'] = $request->has('is_active');

        $leadership->update($validated);

        return redirect()->route('superadmin.website.leadership.index')
            ->with('success', 'Leadership updated successfully.');
    }

    public function destroyLeadership(Leadership $leadership)
    {
        if ($leadership->photo) {
            Storage::disk('public')->delete($leadership->photo);
        }
        $leadership->delete();

        return redirect()->route('superadmin.website.leadership.index')
            ->with('success', 'Leadership deleted successfully.');
    }

    // Policy Management
    public function policies()
    {
        $policies = Policy::orderBy('order')->paginate(10);
        return view('backend.superadmin.website.policies.index', compact('policies'));
    }

    public function createPolicy()
    {
        return view('backend.superadmin.website.policies.create');
    }

    public function storePolicy(Request $request)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'category' => 'nullable|string|max:100',
            'description' => 'nullable|string',
            'content' => 'required|string',
            'icon' => 'nullable|string|max:50',
            'color' => 'nullable|string|max:20',
            'slug' => 'nullable|string|max:255|unique:policies,slug',
            'order' => 'nullable|integer',
        ]);

        if (empty($validated['slug'])) {
            $validated['slug'] = Str::slug($validated['title']);
        }

        $validated['is_active'] = $request->has('is_active');

        Policy::create($validated);

        return redirect()->route('superadmin.website.policies.index')
            ->with('success', 'Policy created successfully.');
    }

    public function editPolicy(Policy $policy)
    {
        return view('backend.superadmin.website.policies.edit', compact('policy'));
    }

    public function updatePolicy(Request $request, Policy $policy)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'category' => 'nullable|string|max:100',
            'description' => 'nullable|string',
            'content' => 'required|string',
            'icon' => 'nullable|string|max:50',
            'color' => 'nullable|string|max:20',
            'slug' => 'nullable|string|max:255|unique:policies,slug,' . $policy->id,
            'order' => 'nullable|integer',
        ]);

        if (empty($validated['slug'])) {
            $validated['slug'] = Str::slug($validated['title']);
        }

        $validated['is_active'] = $request->has('is_active');

        $policy->update($validated);

        return redirect()->route('superadmin.website.policies.index')
            ->with('success', 'Policy updated successfully.');
    }

    public function destroyPolicy(Policy $policy)
    {
        $policy->delete();

        return redirect()->route('superadmin.website.policies.index')
            ->with('success', 'Policy deleted successfully.');
    }

    // Gallery Management
    public function gallery()
    {
        $images = GalleryImage::orderBy('order')->paginate(12);
        return view('backend.superadmin.website.gallery.index', compact('images'));
    }

    public function createGallery()
    {
        return view('backend.superadmin.website.gallery.create');
    }

    public function storeGallery(Request $request)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
            'image' => 'required|image|mimes:jpeg,png,jpg|max:2048',
            'category' => 'required|string|in:events,facilities,community,awards',
            'order' => 'nullable|integer',
        ]);

        if ($request->hasFile('image')) {
            $validated['image'] = $request->file('image')->store('gallery', 'public');
        }

        $validated['is_active'] = $request->has('is_active');

        GalleryImage::create($validated);

        return redirect()->route('superadmin.website.gallery.index')
            ->with('success', 'Gallery image added successfully.');
    }

    public function editGallery(GalleryImage $gallery)
    {
        return view('backend.superadmin.website.gallery.edit', compact('gallery'));
    }

    public function updateGallery(Request $request, GalleryImage $gallery)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
            'image' => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
            'category' => 'required|string|in:events,facilities,community,awards',
            'order' => 'nullable|integer',
        ]);

        if ($request->hasFile('image')) {
            if ($gallery->image) {
                Storage::disk('public')->delete($gallery->image);
            }
            $validated['image'] = $request->file('image')->store('gallery', 'public');
        }

        $validated['is_active'] = $request->has('is_active');

        $gallery->update($validated);

        return redirect()->route('superadmin.website.gallery.index')
            ->with('success', 'Gallery image updated successfully.');
    }

    public function destroyGallery(GalleryImage $gallery)
    {
        if ($gallery->image) {
            Storage::disk('public')->delete($gallery->image);
        }
        $gallery->delete();

        return redirect()->route('superadmin.website.gallery.index')
            ->with('success', 'Gallery image deleted successfully.');
    }

    // Organizational Roles Management
    public function organizationalRoles()
    {
        $roles = OrganizationalRole::orderBy('order')->orderBy('level')->paginate(10);
        return view('backend.superadmin.website.organizational-roles.index', compact('roles'));
    }

    public function createOrganizationalRole()
    {
        return view('backend.superadmin.website.organizational-roles.create');
    }

    public function storeOrganizationalRole(Request $request)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'subtitle' => 'nullable|string|max:500',
            'icon' => 'nullable|string|max:100',
            'level' => 'required|integer|min:1|max:10',
            'color_start' => 'nullable|string|max:20',
            'color_end' => 'nullable|string|max:20',
            'responsibilities' => 'required|array',
            'responsibilities.*' => 'required|string',
            'stats' => 'nullable|array',
            'stats.*' => 'nullable|string',
            'order' => 'nullable|integer|min:0',
        ]);

        $validated['is_active'] = $request->has('is_active');

        OrganizationalRole::create($validated);

        return redirect()->route('superadmin.website.organizational-roles.index')
            ->with('success', 'Organizational role created successfully.');
    }

    public function editOrganizationalRole(OrganizationalRole $organizationalRole)
    {
        return view('backend.superadmin.website.organizational-roles.edit', compact('organizationalRole'));
    }

    public function updateOrganizationalRole(Request $request, OrganizationalRole $organizationalRole)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'subtitle' => 'nullable|string|max:500',
            'icon' => 'nullable|string|max:100',
            'level' => 'required|integer|min:1|max:10',
            'color_start' => 'nullable|string|max:20',
            'color_end' => 'nullable|string|max:20',
            'responsibilities' => 'required|array',
            'responsibilities.*' => 'required|string',
            'stats' => 'nullable|array',
            'stats.*' => 'nullable|string',
            'order' => 'nullable|integer|min:0',
        ]);

        $validated['is_active'] = $request->has('is_active');

        $organizationalRole->update($validated);

        return redirect()->route('superadmin.website.organizational-roles.index')
            ->with('success', 'Organizational role updated successfully.');
    }

    public function destroyOrganizationalRole(OrganizationalRole $organizationalRole)
    {
        $organizationalRole->delete();

        return redirect()->route('superadmin.website.organizational-roles.index')
            ->with('success', 'Organizational role deleted successfully.');
    }

    // News & Events Management
    public function newsEvents()
    {
        $newsEvents = NewsEvent::orderBy('published_at', 'desc')->paginate(10);
        return view('backend.superadmin.website.news-events.index', compact('newsEvents'));
    }

    public function createNewsEvent()
    {
        return view('backend.superadmin.website.news-events.create');
    }

    public function storeNewsEvent(Request $request)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'content' => 'required|string',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'published_at' => 'required|date',
            'order' => 'nullable|integer|min:0',
        ]);

        if ($request->hasFile('image')) {
            $validated['image'] = $request->file('image')->store('news-events', 'public');
        }

        $validated['is_active'] = $request->has('is_active');

        NewsEvent::create($validated);

        return redirect()->route('superadmin.website.news-events.index')
            ->with('success', 'News/Event created successfully.');
    }

    public function editNewsEvent(NewsEvent $newsEvent)
    {
        return view('backend.superadmin.website.news-events.edit', compact('newsEvent'));
    }

    public function updateNewsEvent(Request $request, NewsEvent $newsEvent)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'content' => 'required|string',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'published_at' => 'required|date',
            'order' => 'nullable|integer|min:0',
        ]);

        if ($request->hasFile('image')) {
            if ($newsEvent->image) {
                Storage::disk('public')->delete($newsEvent->image);
            }
            $validated['image'] = $request->file('image')->store('news-events', 'public');
        }

        $validated['is_active'] = $request->has('is_active');

        $newsEvent->update($validated);

        return redirect()->route('superadmin.website.news-events.index')
            ->with('success', 'News/Event updated successfully.');
    }

    public function destroyNewsEvent(NewsEvent $newsEvent)
    {
        if ($newsEvent->image) {
            Storage::disk('public')->delete($newsEvent->image);
        }
        $newsEvent->delete();

        return redirect()->route('superadmin.website.news-events.index')
            ->with('success', 'News/Event deleted successfully.');
    }

    // Notice Management
    public function notices()
    {
        $notices = Notice::orderBy('published_at', 'desc')->paginate(15);
        return view('backend.superadmin.website.notices.index', compact('notices'));
    }

    public function createNotice()
    {
        return view('backend.superadmin.website.notices.create');
    }

    public function storeNotice(Request $request)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'content' => 'required|string',
            'details' => 'nullable|string',
            'type' => 'required|in:general,emergency,announcement,event',
            'published_at' => 'required|date',
        ]);

        $validated['is_active'] = $request->has('is_active');

        Notice::create($validated);

        return redirect()->route('superadmin.website.notices.index')
            ->with('success', 'Notice created successfully.');
    }

    public function editNotice(Notice $notice)
    {
        return view('backend.superadmin.website.notices.edit', compact('notice'));
    }

    public function updateNotice(Request $request, Notice $notice)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'content' => 'required|string',
            'details' => 'nullable|string',
            'type' => 'required|in:general,emergency,announcement,event',
            'published_at' => 'required|date',
        ]);

        $validated['is_active'] = $request->has('is_active');

        $notice->update($validated);

        return redirect()->route('superadmin.website.notices.index')
            ->with('success', 'Notice updated successfully.');
    }

    public function destroyNotice(Notice $notice)
    {
        $notice->delete();

        return redirect()->route('superadmin.website.notices.index')
            ->with('success', 'Notice deleted successfully.');
    }

    // Contact Info Management
    public function contactInfo()
    {
        $contactInfo = ContactInfo::first();
        return view('backend.superadmin.website.contact-info.edit', compact('contactInfo'));
    }

    public function updateContactInfo(Request $request)
    {
        $validated = $request->validate([
            'address' => 'required|string|max:500',
            'phone' => 'required|string|max:100',
            'email' => 'required|email|max:100',
            'facebook' => 'nullable|url|max:255',
            'twitter' => 'nullable|url|max:255',
            'linkedin' => 'nullable|url|max:255',
            'instagram' => 'nullable|url|max:255',
            'working_hours' => 'nullable|string|max:255',
            'is_active' => 'boolean',
        ]);

        $validated['is_active'] = $request->has('is_active');

        $contactInfo = ContactInfo::first();

        if ($contactInfo) {
            $contactInfo->update($validated);
            $message = 'Contact information updated successfully.';
        } else {
            ContactInfo::create($validated);
            $message = 'Contact information created successfully.';
        }

        return redirect()->route('superadmin.website.contact-info')
            ->with('success', $message);
    }
}
