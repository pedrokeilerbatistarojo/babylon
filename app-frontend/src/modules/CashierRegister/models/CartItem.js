class CartItem {
  constructor(id, label, price, quantity = 1) {
    this.id = id;
    this.label = label;
    this.price = price;
    this.quantity = quantity;
  }

  increment() {
    this.quantity++;
  }

  decrement() {
    if (this.quantity > 1) {
      this.quantity--;
    }
  }

  get subtotal() {
    return this.price * this.quantity;
  }
}

export default CartItem;
