
import { createApp } from 'vue';
import App from './components/App.vue';
import './bootstrap'

const app = createApp(App);

// Если нужно добавить глобальные компоненты или плагины:
// app.component('example-component', ExampleComponent);
// app.use(SomePlugin);

app.mount('#app');
