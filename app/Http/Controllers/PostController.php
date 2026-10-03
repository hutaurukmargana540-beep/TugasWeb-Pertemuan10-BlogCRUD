<?php

namespace App\Http\Controllers;

use App\Http\Requests\PostRequest;
use App\Models\Post;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\View\View;
use Throwable;

/**
 * REQ 2: resource controller (7 method) — dibuat dengan
 *        php artisan make:controller PostController --resource --model=Post
 * REQ 8: Route Model Binding (Post $post) + pagination (paginate).
 */
class PostController extends Controller
{
    public function index(Request $request): View
    {
        $posts = Post::query()
            ->search($request->query('q'))
            ->latest()
            ->paginate(6)
            ->withQueryString(); // supaya ?q= ikut terbawa ke halaman berikutnya

        return view('posts.index', compact('posts'));
    }

    public function create(): View
    {
        return view('posts.create');
    }

    public function store(PostRequest $request): RedirectResponse
    {
        try {
            $data = $request->safe()->except('image');

            if ($request->hasFile('image')) {
                $data['image'] = $request->file('image')->store('posts', 'public');
            }

            $post = Post::create($data);
        } catch (Throwable $e) {
            report($e);

            return back()->withInput()->with('error', 'Post gagal disimpan. Silakan coba lagi.');
        }

        return redirect()->route('posts.show', $post)
            ->with('success', 'Post berhasil dibuat.');
    }

    public function show(Post $post): View
    {
        return view('posts.show', compact('post'));
    }

    public function edit(Post $post): View
    {
        return view('posts.edit', compact('post'));
    }

    public function update(PostRequest $request, Post $post): RedirectResponse
    {
        try {
            $data = $request->safe()->except('image');

            if ($request->hasFile('image')) {
                $this->deleteImage($post);
                $data['image'] = $request->file('image')->store('posts', 'public');
            }

            $post->update($data);
        } catch (Throwable $e) {
            report($e);

            return back()->withInput()->with('error', 'Post gagal diperbarui. Silakan coba lagi.');
        }

        return redirect()->route('posts.show', $post)
            ->with('success', 'Post berhasil diperbarui.');
    }

    /** Soft delete: data masuk "tempat sampah", belum hilang permanen. */
    public function destroy(Post $post): RedirectResponse
    {
        try {
            $post->delete();
        } catch (Throwable $e) {
            report($e);

            return back()->with('error', 'Post gagal dihapus.');
        }

        return redirect()->route('posts.index')
            ->with('success', 'Post dipindahkan ke tempat sampah.');
    }

    // ---------------- BONUS: tempat sampah (soft delete) ----------------

    public function trash(): View
    {
        $posts = Post::onlyTrashed()->latest('deleted_at')->paginate(6);

        return view('posts.trash', compact('posts'));
    }

    public function restore(Post $post): RedirectResponse
    {
        $post->restore();

        return redirect()->route('posts.trash')->with('success', 'Post berhasil dipulihkan.');
    }

    public function forceDelete(Post $post): RedirectResponse
    {
        $this->deleteImage($post);
        $post->forceDelete();

        return redirect()->route('posts.trash')->with('success', 'Post dihapus permanen.');
    }

    private function deleteImage(Post $post): void
    {
        if ($post->image) {
            Storage::disk('public')->delete($post->image);
        }
    }
}
