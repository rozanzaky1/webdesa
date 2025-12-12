<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class NewsController extends Controller
{
    public function index(Request $request)
    {
        $news = $this->getNews();
        $categories = $this->getCategories();
        
        // Filter by search
        if ($request->filled('search')) {
            $search = strtolower($request->search);
            $news = array_filter($news, function($item) use ($search) {
                return str_contains(strtolower($item['title']), $search) ||
                       str_contains(strtolower($item['content']), $search);
            });
        }
        
        // Filter by category
        if ($request->filled('category')) {
            $news = array_filter($news, function($item) use ($request) {
                return $item['category'] === $request->category;
            });
        }
        
        // Convert to paginated collection
        $news = collect(array_values($news));
        $perPage = 9;
        $currentPage = $request->get('page', 1);
        $pagedData = $news->forPage($currentPage, $perPage);
        
        $news = new \Illuminate\Pagination\LengthAwarePaginator(
            $pagedData,
            $news->count(),
            $perPage,
            $currentPage,
            ['path' => $request->url(), 'query' => $request->query()]
        );
        
        return view('frontend.news.index', compact('news', 'categories'));
    }
    
    public function show($slug)
    {
        $news = $this->getNewsBySlug($slug);
        
        if (!$news) {
            abort(404, 'Berita tidak ditemukan');
        }
        
        // Get related news
        $relatedNews = $this->getRelatedNews($news['category'], $news['id'], 5);
        
        return view('frontend.news.show', compact('news', 'relatedNews'));
    }
    
    private function getNews()
    {
        if (!Storage::disk('local')->exists('news.json')) {
            return [];
        }
        
        $news = json_decode(Storage::disk('local')->get('news.json'), true) ?? [];
        
        // Filter published only
        $published = array_filter($news, function($item) {
            return $item['status'] === 'published';
        });
        
        // Sort by published_at descending
        usort($published, function($a, $b) {
            return strtotime($b['published_at']) - strtotime($a['published_at']);
        });
        
        return $published;
    }
    
    private function getNewsBySlug($slug)
    {
        $news = $this->getNews();
        
        foreach ($news as $item) {
            if ($item['slug'] === $slug) {
                return $item;
            }
        }
        
        return null;
    }
    
    private function getRelatedNews($category, $excludeId, $limit = 5)
    {
        $news = $this->getNews();
        
        $related = array_filter($news, function($item) use ($category, $excludeId) {
            return $item['category'] === $category && $item['id'] !== $excludeId;
        });
        
        return array_slice(array_values($related), 0, $limit);
    }
    
    private function getCategories()
    {
        return [
            'Berita Desa',
            'Pengumuman',
            'Kegiatan',
            'Pembangunan',
            'Kesehatan',
            'Pendidikan',
            'Sosial Budaya',
            'Ekonomi',
        ];
    }
}
