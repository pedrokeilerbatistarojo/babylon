import io from "socket.io-client";
const env = import.meta.env;
import {Subject} from "rxjs";
import { debounceTime } from "rxjs/operators";

class WebSocketService {
  constructor() {
    this.socket = null;
    this.messageSubject = new Subject();
    this.isProcessing = false;
  }

  connect(channel, onMessageCallback) {
    if (!channel) {
      console.error("No channel specified for WebSocket connection");
      return;
    }

    this.messageSubject.pipe(
      debounceTime(1000),
    ).subscribe((lastMessage) => {
      if (typeof onMessageCallback === "function") {
        onMessageCallback(lastMessage);
      }
    });

    this.socket = io(env.VITE_API_BASE_URL, {
      autoConnect: true,
      path: '/socket.io',
      transports: ['websocket'],
    });

    this.socket.on("connect", () => {
      console.log("Connected:", this.socket);

      this.socket.emit("join", channel);

      this.socket.on("message", (message) => {
        this.messageSubject.next(message);
      });
    });

    this.socket.on("disconnect", () => {
      console.log("Disconnected:", this.socket.id);
    });
  }

  disconnect() {
    if (this.socket) {
      this.socket.disconnect();
      console.log("WebSocket disconnected");
    }
  }
}

export default new WebSocketService();
