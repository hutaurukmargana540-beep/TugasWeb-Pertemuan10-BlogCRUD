<?php

namespace Tests\Feature;

use App\Models\Post;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Tests\TestCase;

/**
 * Jalankan: php artisan test --filter=PostCrudTest
 * (memakai SQLite in-memory bawaan phpunit.xml, tidak menyentuh database MySQL)
 */
class PostCrudTest extends TestCase
{
    use RefreshDatabase;

    public function test_index_is_paginated(): void
    {
        Post::factory(8)->create();

        $this->get(route('posts.index'))
            ->assertOk()
            ->assertViewHas('posts', fn ($posts) => $posts->count() === 6 && $posts->total() === 8);
    }

    public function test_index_can_search(): void
    {
        Post::factory()->create(['title' => 'Belajar Laravel']);
        Post::factory()->create(['title' => 'Resep Nasi Goreng']);

        $this->get(route('posts.index', ['q' => 'Laravel']))
            ->assertOk()
            ->assertSee('Belajar Laravel')
            ->assertDontSee('Resep Nasi Goreng');
    }

    public function test_store_shows_validation_error_per_field(): void
    {
        $this->post(route('posts.store'), ['title' => 'ab', 'content' => 'pendek'])
            ->assertSessionHasErrors(['title', 'content']);

        $this->assertDatabaseCount('posts', 0);
    }

    public function test_store_creates_post_with_image_and_flash_message(): void
    {
        Storage::fake('public');

        $response = $this->post(route('posts.store'), [
            'title'   => 'Judul Uji Coba',
            'content' => 'Isi post yang cukup panjang untuk lolos validasi.',
            'image'   => UploadedFile::fake()->image('cover.jpg'),
        ]);

        $post = Post::firstOrFail();

        $response->assertRedirect(route('posts.show', $post))->assertSessionHas('success');
        Storage::disk('public')->assertExists($post->image);
    }

    public function test_update_changes_post(): void
    {
        $post = Post::factory()->create();

        $this->put(route('posts.update', $post), [
            'title'   => 'Judul Baru',
            'content' => 'Isi baru yang cukup panjang.',
        ])->assertRedirect(route('posts.show', $post));

        $this->assertDatabaseHas('posts', ['id' => $post->id, 'title' => 'Judul Baru']);
    }

    public function test_destroy_is_soft_delete_and_can_be_restored(): void
    {
        $post = Post::factory()->create();

        $this->delete(route('posts.destroy', $post))
            ->assertRedirect(route('posts.index'))
            ->assertSessionHas('success');
        $this->assertSoftDeleted($post);

        $this->patch(route('posts.restore', $post->id))->assertRedirect(route('posts.trash'));
        $this->assertNotSoftDeleted($post);
    }

    public function test_route_model_binding_returns_404_for_missing_post(): void
    {
        $this->get(route('posts.show', 9999))->assertNotFound();
    }
}
