@extends('layouts.index')

@section('title')
    @parent{{ $news->title  }}
@endsection

@section('content')
    @if ($news)
        <div class="container">
            {{ Breadcrumbs::render('one', $news) }}
            @if ($news->is_private && Auth::check() || !$news->is_private)
                <h1 class="title">
                    {{ $news->title }}
                </h1>
                @if ( $news->image )
                    <div class="img-fluid">
                        <img src="{{ $news->image }}" class="img-fluid mb-2" alt="image">
                    </div>
                @endif
                <p class="mb-2">{!! $news->text !!}</p>
                <p class="mb-2">Подробности в <a href="{{ $news->link }}">источнике</a>.</p>

                <div class="card mb-2">
                    <div class="card-header">
                        Комментарии
                    </div>
                    <div class="card-body">
                        <div class="card-text">
                            <div class="row">
                                <p class="col-2"><strong>Имя</strong></p>
                                <p class="col-9">Комментарий</p>
                            </div>
                            <div class="comments-list">
                                @forelse($comments as $comment)
                                    <div class="row comment-item">
                                        <p class="col-2"><strong>{{ $comment['name'] }}</strong></p>
                                        <p class="col-10">{{ $comment['comment'] }}</p>
                                        <p class="col-12">
                                            <a href="#" data-comment-id="{{ $comment['id'] }}"
                                               class="reply-btn">ответить
                                            </a>
                                        </p>
                                    </div>
                                    @isset($comment['children'])
                                        @include('comments.comments', ['child' => $comment['children']])
                                    @endisset
                                @empty
                                    <div class="no-comments">
                                        Комментариев пока нет
                                    </div>
                                @endforelse
                            </div>
                        </div>
                    </div>
                </div>
                <div class="card">
                    <div class="card-header">
                        Напсиать комментарий
                    </div>
                    <div class="card-body">
                        <div class="card-text">
                            <form>
                                <div class="form-row">
                                    <div class="form-group col-md-6">
                                        <label for="name">Имя</label>
                                        <input type="text" class="form-control" id="name" name="name">
                                        <div id="name-feedback" class="invalid-feedback"></div>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label for="comment">Текст комментария</label>
                                    <textarea class="form-control" id="comment"
                                              placeholder="Напишите ваш комментарий"></textarea>
                                    <div id="comment-feedback" class="invalid-feedback"></div>
                                </div>
                                <button data-news-id="{{ $news->id }}" type="button" class="btn btn-dark"
                                        id="send-comment">Отправить
                                </button>
                            </form>
                        </div>
                    </div>
                </div>
            @else
                <div class="alert alert-info" role="alert">
                    Новость приватная. Зарегистрируйтесь для просмоотра
                </div>
            @endif
        </div>
    @else
        <div class="container">Такой новости нет</div>
    @endif
@endsection
<script>
    document.addEventListener('DOMContentLoaded', () => {
        const name = document.getElementById('name');
        const comment = document.getElementById('comment');
        const sendCommentBtn = document.getElementById('send-comment');
        const newsId = sendCommentBtn.getAttribute('data-news-id');
        // const replyButtons = document.querySelectorAll('.reply-btn');
        const commentsList = document.querySelector('.comments-list');

        function createCommentElement(data) {
            const commentElement = document.createElement('div');
            commentElement.classList.add('row', 'comment-item', 'bg-light');
            commentElement.innerHTML = `<p class="col-2"><strong>${data.name}</strong></p>
                                            <p class="col-9">${data.comment}</p>
                                            <p class="col-1">
                                            <p class="col-12">
                                        </p>
                                        </p>`;
            return commentElement;
        }

        function insertComment(element, wrapper) {
            wrapper.insertAdjacentElement('beforeend', element);
            name.value = '';
            comment.value = '';
        }

        function sendComment() {
            setPreloadBtn(sendCommentBtn);
            axios.put('/comment', {
                name: name.value,
                comment: comment.value,
                news_id: newsId
            })
                .then((response) => {
                    const commentElement = createCommentElement(response.data);
                    const noCommentsElem = document.querySelector('.no-comments');
                    if (noCommentsElem) {
                        noCommentsElem.remove();
                    }
                    insertComment(commentElement, commentsList);
                    setTimeout(() => {
                        setDefaultBtn(sendCommentBtn);
                        document.getElementById('name-feedback').innerHTML = '';
                        document.getElementById('comment-feedback').innerHTML = '';
                        name.classList.remove('is-invalid');
                        comment.classList.remove('is-invalid');
                    }, 500)
                })
                .catch((error) => {
                    if (error.response.status === 422) {
                        const nameError = error.response.data.errors.name;
                        const commentError = error.response.data.errors.comment;
                        toggleErrorMessage(name, nameError);
                        toggleErrorMessage(comment, commentError);
                        setDefaultBtn(sendCommentBtn);
                    }
                })
        }

        function toggleErrorMessage(inputElement, error) {
            if (error) {
                inputElement.classList.add('is-invalid');
                inputElement.nextElementSibling.innerHTML = error;
            } else {
                inputElement.classList.remove('is-invalid');
                inputElement.nextElementSibling.innerHTML = '';
            }
        }

        function setPreloadBtn(btn) {
            btn.setAttribute('disabled', 'disabled');
            btn.innerHTML = '<span class="spinner-grow spinner-grow-sm" role="status" aria-hidden="true"></span>\n' +
                '  Отправляем...'
        }

        function setDefaultBtn(btn) {
            btn.removeAttribute('disabled');
            btn.innerHTML = 'Отправить';
        }

        function sendReplyComment(parentId, elem) {
            const sendCommentReplyBtn = elem.querySelector('.send-comment-reply');
            setPreloadBtn(sendCommentReplyBtn);
            const nameReply = elem.querySelector('.name');
            const commentReply = elem.querySelector('.comment');
            axios.put('/comment', {
                name: nameReply.value,
                comment: commentReply.value,
                news_id: newsId,
                parent_id: parentId
            })
                .then((response) => {
                    elem.previousElementSibling.querySelector('.reply-btn').classList.remove('invisible');
                    const commentElement = createCommentElement(response.data);
                    if (elem.nextElementSibling !== null && elem.nextElementSibling.classList.contains('children')) {
                        elem.nextElementSibling.insertAdjacentElement('beforeend', commentElement);
                        destroyCollapseElement('#reply-input', elem);
                    } else {
                        const childrenWrapper = document.createElement('div');
                        childrenWrapper.classList.add('children');
                        childrenWrapper.insertAdjacentElement('beforeend', commentElement);
                        elem.insertAdjacentElement('afterend', childrenWrapper);
                        destroyCollapseElement('#reply-input', elem);
                    }

                })
                .catch(error => {
                    if (error.response && error.response.status === 422) {
                        const nameError = error.response.data.errors.name;
                        const commentError = error.response.data.errors.comment;
                        setDefaultBtn(sendCommentReplyBtn);
                        toggleErrorMessage(nameReply, nameError);
                        toggleErrorMessage(commentReply, commentError);

                    } else {
                        console.log(error);
                    }
                });
        }

        function createInputGroupElement(parentId) {
            const element = document.createElement('div');
            element.classList.add('children')
            element.innerHTML = `<div class="card reply-input" id="reply-input">
                <div class="card-header card-header-reply-input">
                        <div>Ответ на комментарий комментарий</div>
                         <button type="button" class="close close-btn">
                            <span aria-hidden="true">&times;</span>
                         </button>
                    </div>
                    <div class="card-body">
                        <div class="card-text">
                            <form>
                                <div class="form-row">
                                    <div class="form-group col-md-6">
                                        <label for="name-reply">Имя</label>
                                        <input id="name-reply" type="text" class="form-control name" name="name">
                                        <div id="name-feedback-reply" class="invalid-feedback"></div>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label for="comment-reply">Текст комментария</label>
                                    <textarea id="comment-reply" class="form-control comment"
                                              placeholder="Напишите ваш комментарий"></textarea>
                                    <div id="comment-feedback-reply" class="invalid-feedback"></div>
                                </div>
                                <button data-parent-id="${parentId}" data-news-id="${newsId}" type="button" class="btn btn-dark send-comment-reply" >Отправить</button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>`;
            element.querySelector('.send-comment-reply').addEventListener('click', () => {
                sendReplyComment(parentId, element)
            });
            return element;
        }

        function showCollapseElement(id) {
            $(id).collapse({
                toggle: false
            }).collapse('show');
        }

        function destroyCollapseElement(id, elem = null) {
            $(id).collapse('hide').on('hidden.bs.collapse', function () {
                $(id).remove();
                if (elem !== null) {
                    elem.remove();
                }
            })
        }


        function openInputGroup(event, commentItemElement) {
            const parentId = event.target.dataset.commentId;
            const inputGroupElement = createInputGroupElement(parentId);
            inputGroupElement.querySelector('.close-btn').addEventListener('click', () => {
                destroyCollapseElement('#reply-input');
                commentItemElement.querySelector('.reply-btn').classList.remove('invisible');
            });
            commentItemElement.insertAdjacentElement('afterend', inputGroupElement);
            showCollapseElement('#reply-input');
        }

        sendCommentBtn.addEventListener('click', sendComment);

        commentsList.querySelectorAll('.comment-item').forEach((elem) => {
            elem.querySelector('.reply-btn').addEventListener('click', (evt) => {
                evt.preventDefault();
                openInputGroup(evt, elem);
                elem.querySelector('.reply-btn').classList.add('invisible');
            });
        })
    })


</script>
