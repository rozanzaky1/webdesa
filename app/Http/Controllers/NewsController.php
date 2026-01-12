<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class NewsController extends Controller
{
    private $newsPath = 'news.json';
    private $categoriesPath = 'news_categories.json';

    public function index(Request $request)
    {
        $news = $this->getNews();
        $categories = $this->getCategories();
        
        // Filter by category
        if ($request->has('category') && $request->category !== '') {
            $news = array_filter($news, function($item) use ($request) {
                return $item['category'] === $request->category;
            });
        }

        // Filter by status
        if ($request->has('status') && $request->status !== '') {
            $news = array_filter($news, function($item) use ($request) {
                return $item['status'] === $request->status;
            });
        }

        // Sort by date
        usort($news, function($a, $b) {
            return strtotime($b['created_at']) - strtotime($a['created_at']);
        });

        return view('pages.news.index', compact('news', 'categories'));
    }

    public function create()
    {
        $categories = $this->getCategories();
        return view('pages.news.create', compact('categories'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'category' => 'required|string',
            'content' => 'required|string',
            'excerpt' => 'nullable|string|max:500',
            'image' => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
            'status' => 'required|in:draft,published',
            'is_featured' => 'nullable|boolean',
        ]);

        $news = $this->getNews();

        $newArticle = [
            'id' => uniqid(),
            'title' => $request->title,
            'slug' => Str::slug($request->title),
            'category' => $request->category,
            'content' => $request->content,
            'excerpt' => $request->excerpt ?? Str::limit(strip_tags($request->content), 150),
            'image' => null,
            'status' => $request->status,
            'is_featured' => $request->has('is_featured') ? true : false,
            'views' => 0,
            'created_at' => now()->toDateTimeString(),
            'published_at' => $request->status === 'published' ? now()->toDateTimeString() : null,
        ];

        if ($request->hasFile('image')) {
            $path = $request->file('image')->store('news', 'public');
            $newArticle['image'] = $path;
        }

        $news[] = $newArticle;
        Storage::disk('local')->put($this->newsPath, json_encode($news, JSON_PRETTY_PRINT));

        return redirect()->route('news.index')->with('success', 'Berita berhasil ditambahkan!');
    }

    public function edit($id)
    {
        $news = $this->getNews();
        $article = collect($news)->firstWhere('id', $id);
        $categories = $this->getCategories();

        if (!$article) {
            return redirect()->route('news.index')->with('error', 'Berita tidak ditemukan!');
        }

        return view('pages.news.edit', compact('article', 'categories'));
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'category' => 'required|string',
            'content' => 'required|string',
            'excerpt' => 'nullable|string|max:500',
            'image' => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
            'status' => 'required|in:draft,published',
            'is_featured' => 'nullable|boolean',
        ]);

        $news = $this->getNews();
        $index = collect($news)->search(function ($item) use ($id) {
            return $item['id'] === $id;
        });

        if ($index === false) {
            return redirect()->route('news.index')->with('error', 'Berita tidak ditemukan!');
        }

        $wasPublished = $news[$index]['status'] === 'published';
        
        $news[$index]['title'] = $request->title;
        $news[$index]['slug'] = Str::slug($request->title);
        $news[$index]['category'] = $request->category;
        $news[$index]['content'] = $request->content;
        $news[$index]['excerpt'] = $request->excerpt ?? Str::limit(strip_tags($request->content), 150);
        $news[$index]['status'] = $request->status;
        $news[$index]['is_featured'] = $request->has('is_featured') ? true : false;
        $news[$index]['updated_at'] = now()->toDateTimeString();

        // Set published_at if changing from draft to published
        if (!$wasPublished && $request->status === 'published') {
            $news[$index]['published_at'] = now()->toDateTimeString();
        }

        if ($request->hasFile('image')) {
            // Delete old image
            if (isset($news[$index]['image']) && Storage::disk('public')->exists($news[$index]['image'])) {
                Storage::disk('public')->delete($news[$index]['image']);
            }
            
            $path = $request->file('image')->store('news', 'public');
            $news[$index]['image'] = $path;
        }

        Storage::disk('local')->put($this->newsPath, json_encode(array_values($news), JSON_PRETTY_PRINT));

        return redirect()->route('news.index')->with('success', 'Berita berhasil diperbarui!');
    }

    public function destroy($id)
    {
        $news = $this->getNews();
        $index = collect($news)->search(function ($item) use ($id) {
            return $item['id'] === $id;
        });

        if ($index === false) {
            return redirect()->route('news.index')->with('error', 'Berita tidak ditemukan!');
        }

        // Delete image if exists
        if (isset($news[$index]['image']) && Storage::disk('public')->exists($news[$index]['image'])) {
            Storage::disk('public')->delete($news[$index]['image']);
        }

        unset($news[$index]);
        Storage::disk('local')->put($this->newsPath, json_encode(array_values($news), JSON_PRETTY_PRINT));

        return redirect()->route('news.index')->with('success', 'Berita berhasil dihapus!');
    }

    public function toggleFeatured($id)
    {
        $news = $this->getNews();
        $index = collect($news)->search(function ($item) use ($id) {
            return $item['id'] === $id;
        });

        if ($index === false) {
            return redirect()->route('news.index')->with('error', 'Berita tidak ditemukan!');
        }

        $news[$index]['is_featured'] = !($news[$index]['is_featured'] ?? false);
        Storage::disk('local')->put($this->newsPath, json_encode(array_values($news), JSON_PRETTY_PRINT));

        return redirect()->route('news.index')->with('success', 'Status favorit berhasil diubah!');
    }

    private function getNews()
    {
        if (Storage::disk('local')->exists($this->newsPath)) {
            return json_decode(Storage::disk('local')->get($this->newsPath), true);
        }
        return [];
    }

    private function getCategories()
    {
        if (Storage::disk('local')->exists($this->categoriesPath)) {
            return json_decode(Storage::disk('local')->get($this->categoriesPath), true);
        }
        
        // Default categories
        $categories = ['Pengumuman', 'Kegiatan', 'Pembangunan', 'Kesehatan', 'Pendidikan', 'Lainnya'];
        Storage::disk('local')->put($this->categoriesPath, json_encode($categories, JSON_PRETTY_PRINT));
        return $categories;
    }
}
