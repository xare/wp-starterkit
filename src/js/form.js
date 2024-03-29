document.addEventListener('DOMContentLoaded', function(e) {
    let testimonialForm = document.getElementById('starterkit-testimonial-form');

    testimonialForm.addEventListener('submit', (event) => {
        event.preventDefault();
        // reset the form messages
        resetMessages();

        // collect all the data
        let data = {
            name: testimonialForm.querySelector('[name="name"]').value,
            email: testimonialForm.querySelector('[name="email"]').value,
            message: testimonialForm.querySelector('[name="message"]').value,
            nonce: testimonialForm.querySelector('[name="nonce"]').value,
        };
        console.info(data);
        //validate the name
        if (!data.name) {
            testimonialForm.querySelector('[data-error="invalidName"]').classList.add('show');
            return;
        }
        /* if (!data.email) {
            testimonialForm.querySelector('[data-error="invalidEmail"]').classList.add('show');
            return;
        } */
        if (!data.message) {
            testimonialForm.querySelector('[data-error="invalidMessage"]').classList.add('show');
            return;
        }
        // validate the email
        if (!validateEmail(data.email)) {
            testimonialForm.querySelector('[data-error="invalidEmail"]').classList.add('show');
            return;
        }

        // ajax http post request
        let url = testimonialForm.dataset.url;

        let params = new URLSearchParams(new FormData(testimonialForm)); //collects all the input fields and formats them

        testimonialForm.querySelector('.js-form-submission').classList.add('show');

        fetch(url, {
                method: 'POST',
                body: params
            }).then(results => results.json())
            .catch(error => {
                resetMessages();
                testimonialForm.querySelector('.js-form-error').classList.add('show');
            })
            .then(response => {
                resetMessages();
                //deal with the response
                if (response === 0 || response.status === "error") {
                    testimonialForm.querySelector('.js-form-error').classList.add('show');
                    return;
                }
                testimonialForm.querySelector('.js-form-success').classList.add('show');
                testimonialForm.reset();

            });

        console.log(url);

    });
});

function resetMessages() {
    document.querySelectorAll('.field-msg').forEach(field => field.classList.remove('show'));
}

function validateEmail(email) {
    let regExp = /^(([^<>()\[\]\\.,;:\s@"]+(\.[^<>()\[\]\\.,;:\s@"]+)*)|(".+"))@((\[[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\])|(([a-zA-Z\-0-9]+\.)+[a-zA-Z]{2,}))$/;
    return regExp.test(String(email).toLowerCase());
}