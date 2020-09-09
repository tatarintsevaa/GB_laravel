document.addEventListener('DOMContentLoaded', (event) => {
    document.querySelectorAll('.user-row').forEach((elem) => {
        elem.querySelector('.save').addEventListener('click', (evt) => {
            const currentValue = elem.querySelector('.is-admin').value;
            const id = elem.getAttribute('data-id');
            if (currentValue !== elem.getAttribute('data-isAdmin')) {
                axios.put(`/api/admin/user/${id}/update`, {
                    value: currentValue
                })
                    .then((response) => {
                        if (response.status === 200) {
                            document.querySelector('.main').insertAdjacentHTML('afterbegin',
                                `<div class="container alert alert-success alert-dismissible fade show" role="alert">
                                    Статус пользователя изменен!
                                        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                            <span aria-hidden="true">&times;</span>
                                        </button>
                                </div>`)
                            elem.removeAttribute('data-isAdmin');
                            elem.setAttribute('data-isAdmin', currentValue);
                        }
                    })
                    .catch((error) => {
                        console.log(error);
                    })

            } else {
                evt.preventDefault();
            }

        })
    })
})
