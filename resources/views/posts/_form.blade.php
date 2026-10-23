@csrf

<div>
    <x-input-label for="title" value="Title" />
    <x-text-input id="title" name="title" type="text" class="mt-1 block w-full"
        :value="old('title', $post->title ?? '')" required autofocus />
    <x-input-error :messages="$errors->get('title')" class="mt-2" />
</div>

<div>
    <x-input-label for="category_id" value="Category" />
    <select id="category_id" name="category_id"
        class="mt-1 block w-full border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm">
        <option value="">No category</option>
        @foreach ($categories as $category)
            <option value="{{ $category->id }}"
                @selected((string) old('category_id', $post->category_id ?? '') === (string) $category->id)>
                {{ $category->name }}
            </option>
        @endforeach
    </select>
    <x-input-error :messages="$errors->get('category_id')" class="mt-2" />
</div>

<div>
    <x-input-label for="excerpt" value="Excerpt (short summary)" />
    <textarea id="excerpt" name="excerpt" rows="3"
        class="mt-1 block w-full border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm">{{ old('excerpt', $post->excerpt ?? '') }}</textarea>
    <x-input-error :messages="$errors->get('excerpt')" class="mt-2" />
</div>

<div>
    <x-input-label for="body" value="Body" />
    <textarea id="body" name="body" rows="12" required
        class="mt-1 block w-full border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm">{{ old('body', $post->body ?? '') }}</textarea>
    <x-input-error :messages="$errors->get('body')" class="mt-2" />
</div>

<div>
    <x-input-label for="image" value="Cover image (optional, JPG/PNG/WebP, max 2 MB)" />

    @if (!empty($post->image_path))
        <img src="{{ $post->image_url }}" alt="" class="mt-2 h-40 rounded">
        <label class="mt-2 flex items-center gap-2 text-sm text-gray-700 dark:text-gray-300">
            <input type="checkbox" name="remove_image" value="1"> Remove current image
        </label>
    @endif

    <input id="image" name="image" type="file" accept="image/*"
           class="mt-2 block w-full text-sm text-gray-700 dark:text-gray-300">
    <x-input-error :messages="$errors->get('image')" class="mt-2" />
</div>

<div>
    <x-input-label for="status" value="Status" />
    <select id="status" name="status"
        class="mt-1 block w-full border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm">
        @foreach (['draft' => 'Draft', 'published' => 'Published'] as $value => $label)
            <option value="{{ $value }}" @selected(old('status', $post->status ?? 'draft') === $value)>{{ $label }}</option>
        @endforeach
    </select>
    <x-input-error :messages="$errors->get('status')" class="mt-2" />
</div>