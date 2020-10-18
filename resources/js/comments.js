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
                                            <a data-toggle="collapse" href="#reply-input-group" data-comment-id="${data.id}"
                                                    class="reply-btn">ответить
                                            </a>
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
                commentElement.querySelector('.reply-btn').addEventListener('click', (evt) => {
                    evt.preventDefault();
                    openInputGroup(evt, commentElement);
                })
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
                const commentElement = createCommentElement(response.data);
                commentElement.querySelector('.reply-btn').addEventListener('click', (evt) => {
                    evt.preventDefault();
                    openInputGroup(evt, commentElement);
                })
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
                if (error.response.status === 422) {
                    const nameError = error.response.data.errors.name;
                    const commentError = error.response.data.errors.comment;
                    setDefaultBtn(sendCommentReplyBtn);
                    toggleErrorMessage(nameReply, nameError);
                    toggleErrorMessage(commentReply, commentError);
                }
            });
    }

    function createInputGroupElement(parentId) {
        const element = document.createElement('div');
        element.classList.add('children')
        element.innerHTML = `<div class="card reply-input" id="reply-input">
                <div class="card-header">
                        Ответ на комментарий комментарий
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


    function openInputGroup(event, elem) {
        const parentId = event.target.dataset.commentId;
        const inputGroupElement = createInputGroupElement(parentId);
        elem.insertAdjacentElement('afterend', inputGroupElement);
        showCollapseElement('#reply-input');
    }

    sendCommentBtn.addEventListener('click', sendComment);

    commentsList.querySelectorAll('.comment-item').forEach((elem) => {
        elem.querySelector('.reply-btn').addEventListener('click', (evt) => {
            evt.preventDefault();
            openInputGroup(evt, elem);
        });
    })
})
