<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Feeds') }}
        </h2>
    </x-slot>
    <div class="container" style="margin-top: 20px;">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card">
                    <div class="card-header">
                        {{ __('Feeds') }}
                    </div>
                    <div class="card-body">
                        <div class="col-md-12">
                            @foreach ($f->get_items() as $key => $value)
                                <b>Title: </b>{{ $value->get_title() }}<br/><br/>
                                <b>Content: </b>{!! $value->get_content() !!}<br/><br/><br/>
                            @endforeach
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
