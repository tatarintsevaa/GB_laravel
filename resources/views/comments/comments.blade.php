<div class="children">
    @foreach($child as $item)
        <div class="row comment-item">
            <p class="col-md-2"><strong>{{ $item['name'] }}</strong></p>
            <p class="col-md-10">{{ $item['comment'] }}</p>
            <p class="col-md-12">
                <a href="#" data-comment-id="{{ $item['id'] }}"
                   class="reply-btn">ответить
                </a>
            </p>
        </div>
        @isset($item['children'])
            @include('comments.comments', ['child' => $item['children']])
        @endisset
    @endforeach
</div>
