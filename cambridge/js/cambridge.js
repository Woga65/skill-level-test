/* wait until all elements are present in the DOM */
document.addEventListener('DOMContentLoaded', () => {


  const endPoint = 'php/cambridge.php';
  const myForm = document.getElementById('ajax-form');
  const submit = document.querySelector('.ajax-form .submit-button');
  const formFields = document.querySelectorAll('.ajax-form .form-field');
  const isDirty = new Array(formFields.length).fill(false);


  
  /* check whether invalid data has been entered into a form field */
  formFields.forEach((ff, i) => {
    ['blur', 'keyup'].forEach(ev => ff.addEventListener(ev, e => {
      if (e.type == 'blur') {
        isDirty[i] = ff.value ? true : false;
      }
      !ff.value || !isDirty[i]
        ? ff.classList.toggle('invalid', false)
        : ff.classList.toggle('invalid', !ff.checkValidity());
    }));
  });


  /* on submit button clicked, check if all required data has been entered correctly */
  submit.addEventListener('click', e => {
    let invalidField = null;
    formFields.forEach(ff => {
      invalidField = ff.required
        ? (ff.checkValidity() ? invalidField : invalidField ? invalidField : ff)
        : invalidField;
      ff.classList.toggle('invalid', !ff.checkValidity());
    });
    if (invalidField) {
      e.preventDefault();
      invalidField.focus();
    }
  });


  /* on submit send form data to the end point */
  myForm.addEventListener('submit', async e => {
    e.preventDefault();
    const formData = new FormData(myForm);
    const formDataObject = Object.fromEntries(formData);
    submitRequest(endPoint, formDataObject)
      .then(result => {
          dataToForm(result.ok ? result.data.message : new Array(formFields.length).fill(''));
          console.log('data: ', result); 
      });
  });


  /* move received data to form */
  function dataToForm(message) {
    formFields.forEach((ff, i) => {
      ff.value = message[i];
      isDirty[i] = false;
    });
    formFields[0].focus();
  }

  
  /* send request to the endpoint */
  async function submitRequest(endPoint, dataObject) {
    try {
        const response = await fetch(endPoint, {
            method: 'POST',
            body: JSON.stringify(dataObject),
            headers: { 'Content-Type': 'application/json' }
        });
        return await response.json();
    } catch (err) {
        console.error(err);
        return { err: err, ok: false, data: {} };
    }
  }


});
