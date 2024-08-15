<template>
  <div class="table-responsive">
    <table class="table table-bordered">
      <thead>
      <tr>
        <th>ID</th>
        <th>Ім'я</th>
        <th>Email</th>
        <th>Номер телефону</th>
        <th>Зображення</th>
      </tr>
      </thead>
      <tbody>
      <tr v-for="user in users" :key="user.id">
        <td>{{ user.id }}</td>
        <td>{{ user.name }}</td>
        <td>{{ user.email }}</td>
        <td>{{ user.phone ?? '' }}</td>
        <td class="text-center">
          <img :src="user.image" alt="User Image" class="img-thumbnail"
               style="max-width: 100px; height: auto;"/>
        </td>
      </tr>
      </tbody>
    </table>
  </div>

  <div class="text-center mt-4 mb-5">
    <button class="btn btn-primary" @click="loadMoreUsers" :disabled="currentPage >= totalPages">Показати більше
    </button>
  </div>
</template>

<script>
import axios from '../axios';

export default {
  name: 'UserLists',

  data() {
    return {
      users: [],
      currentPage: 1,
      totalPages: 1,
    }
  },
  methods: {
    async fetchUsers(page = 1) {
      try {
        const response = await axios.get('users', {
          params: {
            'page': page,
            'count': 6,
          }
        });

        if (response.data.success) {
          this.users = page === 1 ? response.data.users : [...this.users, ...response.data.users];
          this.currentPage = response.data.page;
          this.totalPages = response.data.total_pages;
        }
      } catch (error) {
        console.error('Помилка при отриманні користувачів:', error);
      }
    },
    loadMoreUsers() {
      if (this.currentPage < this.totalPages) {
        this.fetchUsers(this.currentPage + 1);
      }
    }
  },
  mounted() {
    this.fetchUsers();
  }
}

</script>


<style scoped>

</style>