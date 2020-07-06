<?
class Promo
{
  public $id;
  public $name;
  public $startDate;
  public $finishDate;
  public $status;

  public function __construct($id, $name, $startDate)
  {
    $this->id = $id;
    $this->name = $name;
    $this->startDate = $startDate;
    $this->setStatus('Pending');
  }

  protected function setStatus($status)
  {
    $this->status = $status;
  }

  public function start()
  {
    $this->setStatus('Active');
  }
  public function stop()
  {
    $this->setStatus('Ended');
    $this->finishDate = date('Y-m-d H:i');
  }
  public function pause()
  {
    $this->setStatus('Paused');
  }

  public function showDescription()
  {
    $finish = ($this->finishDate) ? $this->finishDate : 'not established';
    echo "<pre>
    Name: {$this->name}
    Start from: {$this->startDate}
    Last until: {$finish}
    Current Status: {$this->status}
    </pre>";
  }
  public function applyToCart(Cart $cart)
  {
    return;
  }
}

class PromoDiscount extends Promo
{
  public $categories = [];
  public $discount = 0;

  public function __construct($id, $name, $startDate, Array $categories, $discount)
  {
    $this->categories = $categories;
    $this->discount = $discount;
    parent::__construct($id, $name, $startDate);
  }
  public function applyToCart(Cart $cart)
  {
    $cart->amount = $cart->amount - ($cart->amount * $this->discount / 100);
  }
}

class PromoPresent extends Promo
{
  public $amount;
  public $present = '';

  public function __construct($id, $name, $startDate, $amount, $present)
  {
    $this->amount = $amount;
    $this->present = $present;
    parent::__construct($id, $name, $startDate);
  }
  public function applyToCart(Cart $cart)
  {
    if ($cart->amount >= $this->amount) {
      $cart->add($this->present);
    }
  }
}

class Cart
{
  public $amount;
  public $products = [];

  public function __construct($amount)
  {
    $this->amount = $amount;
  }
  public function add($product)
  {
    $this->products[] = $product;
  }
}

$promo = new Promo(4, 'Summer Discount', '2020-07-06 14:01');
$cart = new Cart(100);
$promoPresent = new PromoPresent(1, 'Present for 100$', '2020-07-06 14:01', 100, 'Free Shipping');
$promoPresent->applyToCart($cart);

var_dump($cart);
$promoPresent->stop();
$promoPresent->showDescription();