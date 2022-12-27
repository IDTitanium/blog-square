<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Dashboard') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <a classs="btn btn-primary" href="{{ route('home') }}">
                <button class="btn btn-primary my-2">
                < Go to home page
                </button>
            </a>

            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 bg-white border-b border-gray-200">
                    <p><strong>Create a new post</strong></p>
                    <x-auth-validation-errors class="mb-4" :errors="$errors" />
                    <form class="row g-3" method="post" action="{{route('post.create')}}">
                        @csrf

                        <div class="col-12">
                          <label for="tititle" class="form-label">Title</label>
                          <input type="text" class="form-control" id="title" name="title" placeholder="A new title...">
                        </div>
                        <div class="col-12">
                          <label for="desc" class="form-label">Description</label>
                          <textarea type="text" class="form-control" id="description" name="description" placeholder="As the saying goes..."></textarea>
                        </div>
                        <div class="col-12">
                          <button type="submit" class="btn btn-primary">Publish</button>
                        </div>
                    </form>
                </div>
                <div class="p-6 bg-white border-b border-gray-200">
                <h3 class="text-center">My Blog posts</h3>
                    <x-posts-view :posts="$posts"/>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
