class CartItem {
  constructor(id, name, price, quantity = 1) {
    this.id = id;
    this.name = name;
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
