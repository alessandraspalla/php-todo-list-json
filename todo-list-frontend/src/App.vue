<script>
import axios from 'axios';

export default {
  data() {
    return {
      todos: [],
      newTodo: {
        "todo": "",
        "status": false
      }
    }
  },
  methods: {
    onSubmit() {
      const url = "http://localhost/php-todo-list-json/to-do-list-backend/newTodo.php";
      const data = this.newTodo;
      const headers = {
        headers: { 'Content-Type': 'multipart/form-data' }
      };

      if (this.newTodo.todo !== '') {
        axios.post(url, data, headers)
          .then(res => {
            const data = res.data;
            this.todos = data;

            this.newTodo.todo = "";
          })
      }
    },
    deleteTodo(index) {
      const url = "http://localhost/php-todo-list-json/to-do-list-backend/deleteTodo.php";
      const data = { "index": index };
      const headers = {
        headers: { 'Content-Type': 'multipart/form-data' }
      };

      axios.post(url, data, headers)
        .then(res => {
          const data = res.data;
          this.todos = data;
        })
    }
  },
  mounted() {
    axios.get("http://localhost/php-todo-list-json/to-do-list-backend/todo.php")
      .then(res => {
        const data = res.data;
        this.todos = data;
        console.log(this.todos);
      })
  }
}
</script>

<template>
  <h1>Todo List</h1>
  <ul>
    <li v-for="(todo, idx) in todos" :key="idx">
      {{ todo.todo }}
      <button @click="deleteTodo(idx)">trash</button>
    </li>
  </ul>
  <form @submit.prevent="onSubmit">
    <input type="text" name="todo" v-model="newTodo.todo">
    <input type="submit" value="Inserisci">
  </form>
</template>

<style lang="scss">
li {
  width: 300px;
  display: flex;
  justify-content: space-between;
}
</style>
