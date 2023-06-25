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
    },
    toggleLineThrough(index) {
      console.log('mi stai cliccando', index);
      if (this.todos[index].status === 'true') {
        this.todos[index].status = 'false'
      } else {
        this.todos[index].status = 'true'
      }
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
  <div class="container">
    <h1>Todo List</h1>
    <ul>
      <li v-for="(todo, idx) in todos" :key="idx">
        <span class="toggle" :class="todo.status === 'true' ? 'line-through' : ''" @click="toggleLineThrough(idx)">{{
          todo.todo }}</span>
        <button @click="deleteTodo(idx)">
          <i class="fa-regular fa-trash-can"></i>
        </button>
      </li>
    </ul>
    <form @submit.prevent="onSubmit">
      <input class="searchbar" type="text" name="todo" v-model="newTodo.todo" placeholder="Inserisci un elemento">
      <input class="submit" type="submit" value="Inserisci">
    </form>
  </div>
</template>

<style lang="scss">
* {
  margin: 0;
  padding: 0;
  box-sizing: border-box;
  font-family: 'Inter', sans-serif;
}

body {
  background-color: #011632;
  text-align: center;
  height: 100vh;
  display: flex;
  justify-content: center;
  align-items: center;

  h1 {
    color: #999;
    font-size: 3.5rem;
    font-weight: 300;
  }

  ul {
    background-color: #fff;
    width: 50vw;
    max-width: 800px;
    margin: 0 auto;
    border-radius: 10px;
    margin-block: 20px;

    li {
      display: flex;
      justify-content: space-between;
      padding: 15px;
      border-bottom: 1px solid #999;
      align-items: center;

      &:last-child {
        border: hidden;
      }

      button {
        padding: 5px;
        border-radius: 3px;
        background-color: red;
        color: #fff;
        border: hidden;
        font-size: 1rem;
      }
    }
  }

  form {
    width: 50vw;
    max-width: 800px;
    margin: 0 auto;

    input {
      height: 40px;
    }

    .searchbar {
      width: calc(50vw - 73px);
      border-radius: 5px 0 0 5px;
      padding: 5px;
    }

    .submit {
      border-radius: 0 5px 5px 0;
      padding: 10px;
      color: #d19a15;
      border: 2px solid #d19a15;
      background-color: #011632;
    }
  }
}

.line-through {
  text-decoration: line-through;
}

.toggle {
  cursor: pointer;
}
</style>
