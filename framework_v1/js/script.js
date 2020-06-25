// ЗАГРУЗКА
document.addEventListener('DOMContentLoaded', () => {
  // установить calcType по умолчанию, если не указан
  const calcType = document.getElementById('calcType');
  if (calcType.value === '') calcType.value = 'select';

  // переключить на нужный тип
  setCalcTypeStyles();
  // установить стили для операций, если есть
  if (document.getElementById('set_oper').value !== '') setOperationStyles();
});

// ПЕРЕКЛЮЧАТЕЛЬ
document.getElementById('typeToogle').addEventListener('change', () => {
  // меняет значение #calcType
  changeCalcTypeValue();
  // меняет лейбл и стили блоков
  setCalcTypeStyles();
});

// меняет значение #calcType
function changeCalcTypeValue() {
  const calcType = document.getElementById('calcType');
  if (calcType.value === 'select') calcType.value = 'button';
  else calcType.value = 'select';
}

// меняет лейбл и стили блоков
function setCalcTypeStyles() {
  const calcType = document.getElementById('calcType').value;
  const label = document.querySelector('label[for="typeToogle"]');
  const buttonDiv = document.getElementById('buttonDiv');
  const selectDiv = document.getElementById('selectDiv');

  if (calcType === 'button') {
    buttonDiv.classList.add('d-flex');
    buttonDiv.classList.remove('d-none');
    selectDiv.classList.add('d-none');
    label.innerText = "Toggle to select type";
  }
  else {
    selectDiv.classList.remove('d-none');
    buttonDiv.classList.remove('d-flex');
    buttonDiv.classList.add('d-none');
    label.innerText = "Toggle to button type";
  }

}

// ВЫБОР ОПЕРАЦИИ (КНОПКИ И СЕЛЕКТ)
document.querySelector('select[name="oper"]').addEventListener('change', setOperation);
document.querySelectorAll('button[name="oper"]').forEach((el) => {
  el.addEventListener('click', setOperation);
});

// группа функций при смене операции
function setOperation(event) {
  // установить значение в скрытое поле
  changeOperationValue(event);
  // изменить стили элементов в зав-ти от set_oper
  setOperationStyles();
}

// установить значение операции в скрытое поле set_oper
function changeOperationValue(event) {
  document.getElementById('set_oper').value = event.currentTarget.value;
}

// изменить стили элементов в зав-ти от set_oper
function setOperationStyles() {
  const value = document.getElementById('set_oper').value;
  const button = document.querySelector('button[value="' + value + '"]');

  document.querySelectorAll('button[name="oper"]').forEach((el) => {
    el.removeAttribute('disabled');
    el.classList.remove('btn-secondary');
    el.classList.add('btn-outline-secondary');
  });
  button.setAttribute('disabled', 'disabled');
  button.classList.add('btn-secondary');
  button.classList.remove('btn-outline-secondary');

  document.querySelector('option[value="' + value + '"]').setAttribute('selected', 'selected');
}
