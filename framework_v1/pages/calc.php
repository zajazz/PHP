<?php
// Сложение
function sum($a, $b) {
    return $a + $b;
}

// Вычитание
function sub($a, $b) {
    return $a - $b;
}

// Умножение
function mult($a, $b) {
    return $a * $b;
}

// Деление
function div($a, $b) {
  return ($b == 0) ? "Division by zero is impossible" : $a / $b;
}

function mathOperation($arg1, $arg2, $operation) {
  return $operation($arg1, $arg2);
}



$operation = $_GET['operation'];
$resultString = '';
$firstNumber = $_GET['number1'];
$secondNumber = $_GET['number2'];



if ($_GET && function_exists($operation)) {
  if (is_numeric($firstNumber) && is_numeric($secondNumber)) {
    $signs = [ 'sum' => '+', 'sub' => '-', 'mult' => '*', 'div' => '/' ];
    $counting = mathOperation($_GET['number1'], $_GET['number2'], $operation);
    $resultString = "{$firstNumber} {$signs[$operation]} {$secondNumber} = {$counting}";
  } else {
    $resultString = "Uncorrect number(s)";
  }
}

?>



  <div class="row d-flex flex-column">
    <div class="col">
      <nav class="navbar navbar-light bg-light">
        <a class="navbar-brand" href="#">
          <span class="d-inline-block align-middle text-primary" style="font-size: 40px;">
            <i class="fas fa-calculator "></i>
          </span>
          <span class="h3 align-middle ml-2">Calculator</span>
        </a>
      </nav>

    <div class="col-9 mt-5">
      <div class="custom-control custom-switch">
          <input type="checkbox" class="custom-control-input" id="typeToogle">
          <label class="custom-control-label" for="typeToogle">
          Toggle to button type
        </label>
      </div>
    </div>

    <!-- ФОРМА  -->
    <div class="col-9 mt-5">
    <form method="GET">
      <div class="form-row d-flex flex-wrap">

        <div class="form-group col-3 d-flex flex-column justify-content-end">
          <label for="input1">First number</label>
          <input name="number1" type="text" class="form-control" id="input1" required="" value="<?php echo $firstNumber; ?>">
        </div>

        <!-- КНОПКИ -->
        <div id="buttonDiv" class="form-group col-3 d-none align-items-end">
          <div class="d-flex flex-wrap justify-content-center ">
            <button name="oper" value="sum" type="button" class="btn btn-outline-secondary sign mx-1 mt-1"><i class="fas fa-plus"></i></button>
            <button name="oper" value="sub" type="button" class="btn btn-outline-secondary sign mx-1 mt-1"><i class="fas fa-minus"></i></button>
            <button name="oper" value="mult" type="button" class="btn btn-outline-secondary sign mx-1 mt-1"><i class="fas fa-times"></i></button>
            <button name="oper" value="div" type="button" class="btn btn-outline-secondary sign mx-1 mt-1"><i class="fas fa-divide"></i></button>
          </div>
        </div>

        <!-- СПИСОК -->
        <div id="selectDiv" class="form-group col-3">
          <label for="select1">Operation</label>
          <select name="oper"  id="select1" class="form-control">
              <option ></option>
              <option value="sum">+</option>
              <option value="sub">-</option>
              <option value="mult">*</option>
              <option value="div">/</option>
          </select>
        </div>

        <div class="form-group col-3 d-flex flex-column justify-content-end">
          <label for="input2">Second number</label>
          <input name="number2" type="text" class="form-control" id="input2" required="" value="<?php echo $secondNumber; ?>">
        </div>

        <div class="form-group col-auto d-flex align-items-end">
          <input name="operation" type="hidden"value="<?php echo $operation; ?>" id="set_oper" >
          <input name="page" type="hidden" value="<?php echo $_GET['page'] ?>">
          <input name="type" type="hidden" value="<?php echo $_GET['type'] ?>" id="calcType">
          <button type="submit" class="btn btn-primary form-control">Сount up</button>
        </div>

      </div>
    </form>

  </div>

  <!-- РЕЗУЛЬТАТ -->
  <div class="col-9 mt-3 w-75">
    <div class="input-group mb-3">
      <div class="input-group-prepend">
        <span class="input-group-text">Result</span>
      </div>
      <span class="form-control overflow-auto"><?php echo $resultString; ?></span>

    </div>
  </div>


  <!-- ЗАДАНИЕ -->
  <div class="accordion m-3 pt-5" id="accordionExample">
    <div class="card">
      <div class="card-header" id="headingOne">
        <h5 class="mb-0">
          <button class="btn btn-link" type="button" data-toggle="collapse" data-target="#collapseOne" aria-expanded="true" aria-controls="collapseOne">Задание
          </button>
        </h5>
      </div>

      <div id="collapseOne" class="collapse" aria-labelledby="headingOne" data-parent="#accordionExample" aria-expanded="false">
        <div class="card-body">
          <p>1. Создать форму-калькулятор с операциями: сложение, вычитание, умножение, деление. Не забыть обработать деление на ноль!
            Выбор операции можно осуществлять с помощью тега &lt;select>.</p>
          <p>2. Создать калькулятор, который будет определять тип выбранной пользователем операции, ориентируясь на нажатую кнопку.</p>
        </div>
      </div>
    </div>
  </div>

<script src="/js/script.js"></script>




