
function validateEmailDomain(email) {
  if (!email) return 'El email es obligatorio.';
  const parts = email.split('@');
  if (parts.length !== 2) return 'Formato de correo inválido.';
  const domain = parts[1].toLowerCase();
  const personal = ['gmail.com','hotmail.com','outlook.com','yahoo.com','icloud.com','live.com'];
  if (personal.includes(domain)) return 'No se aceptan correos personales. Usa tu correo universitario (ej. @uvg.edu.gt).';
  if (domain.includes('uvg.edu.gt')) return '';
  if (/\.edu(\.|$)/i.test(domain)) return '';
  return 'El dominio "' + domain + '" no parece ser universitario. Usa @uvg.edu.gt u otro dominio .edu.';
}

function showMessage(container, message, type) {
  if (!container) return;
  container.textContent = message;
  container.classList.remove('message-success','message-error','message-inline');
  if (type === 'error') {
    container.classList.add('message-error','message-inline');
  } else if (type === 'success') {
    container.classList.add('message-success','message-inline');
  } else {
    container.classList.add('message-inline');
  }
}

document.addEventListener('DOMContentLoaded', function() {

  const regForm = document.querySelector('.reg-form');
  if (regForm) {
    const mensajeError = document.getElementById('mensaje-error');
    regForm.addEventListener('submit', function(e) {
  
      const nombre = (regForm.querySelector('input[name="nombre"]') || {}).value || '';
      const email = (regForm.querySelector('input[name="email"]') || {}).value || '';
      const password = (regForm.querySelector('input[name="password"]') || {}).value || '';
      const status = (regForm.querySelector('select[name="status"]') || {}).value || '';
      const terms = (regForm.querySelector('input[name="terms"]') || {}).checked || false;

 
      showMessage(mensajeError, '', '');

      if (!nombre.trim()) { e.preventDefault(); showMessage(mensajeError, 'El nombre es obligatorio.', 'error'); return false; }
      const emailErr = validateEmailDomain(email.trim());
      if (emailErr) { e.preventDefault(); showMessage(mensajeError, emailErr, 'error'); return false; }
      if (!password) { e.preventDefault(); showMessage(mensajeError, 'La contraseña es obligatoria.', 'error'); return false; }
      if (!status) { e.preventDefault(); showMessage(mensajeError, 'Debes seleccionar un estatus.', 'error'); return false; }
      if (!terms) { e.preventDefault(); showMessage(mensajeError, 'Debes aceptar los términos de uso.', 'error'); return false; }
      return true;
    });
  }

  const loginForms = document.querySelectorAll('form input[name="form_type"][value="login"]').forEach(function(hidden){
    const form = hidden.closest('form');
    if (!form) return;
    const loginMsg = form.querySelector('#login-msg') || form.querySelector('.login-msg');
    form.addEventListener('submit', function(e) {
      
      const email = (form.querySelector('input[name="email"]') || {}).value || '';
      const password = (form.querySelector('input[name="password"]') || {}).value || '';
      
      if (loginMsg) showMessage(loginMsg, '', '');
      if (!email || !password) { e.preventDefault(); if (loginMsg) showMessage(loginMsg, 'Email y contraseña son obligatorios.', 'error'); return false; }
      const emailErr = validateEmailDomain(email.trim());
      if (emailErr) { e.preventDefault(); if (loginMsg) showMessage(loginMsg, emailErr, 'error'); return false; }
      return true;
    });
  });
});

