<template>
  <div class="container mt-5">
    <h1 class="mb-4">Користувачі</h1>

    <div class="row mb-4">
      <div class="col-md-6">
        <form @submit.prevent="createUser">
          <div class="form-group">
            <label for="firstname">Ім'я:</label>
            <input v-model="userData.name" type="text" id="firstname" class="form-control"
                   placeholder="Введіть ім'я" required>
          </div>
          <div class="form-group mt-2">
            <label for="email">Email:</label>
            <input v-model="userData.email" type="email" id="email" class="form-control" placeholder="Введіть email"
                   required>
          </div>
          <div class="form-group mt-2">
            <label for="phone">Телефон:</label>
            <input v-model="userData.phone" type="text" id="phone" class="form-control"
                   placeholder="Введіть номер телефону">
          </div>
          <div class="form-group mt-2">
            <label for="position">Позиція:</label>
            <select v-model="userData.position_id" id="position" class="form-control" required>
              <option value="null" selected disabled>Оберіть позицію</option>
              <option v-for="position in userPositions" :key="position.id" :value="position.id">
                {{ position.position }}
              </option>
            </select>
          </div>
          <div class="form-group mt-2">
            <label for="image">Зображення*:</label>
            <input type="file" id="image"
                   class="form-control"
                   @change="handleFileUpload"
                   required>
          </div>
          <div v-if="message" class="d-flex justify-content-center align-items-center mt-3 border rounded">
            <p class="mb-1 mt-1"> {{ message }}</p>
          </div>
          <button type="submit" class="btn btn-primary mt-3">Додати Користувача</button>
        </form>
      </div>
    </div>

    <UserLists/>

  </div>
</template>

<script>
import axios from './axios';
import UserLists from "@/components/UserLists.vue";

export default {
  components: {UserLists},

  data() {
    return {
      userData: {
        name: '',
        email: '',
        phone: '',
        position_id: null,
        image: null,
      },
      userPositions: [],
      message: '',
    };
  },

  methods: {
    async getUserPositions() {
      const response = await axios.get('positions');
      this.userPositions = response.data;
    },
    handleFileUpload(event) {
      this.userData.image = event.target.files[0];
    },
    async createUser() {
      this.message = '';
      const token = await this.getApi();

      try {
        const response = await axios.post('users', this.userData, {
          headers: {
            'Content-Type': 'multipart/form-data',
            'Authorization': token.token
          },
        })
        this.message = response.data.message

      } catch (error) {
        console.error('Помилка при регістрації користувача:', error);
      }

    },
    async getApi() {
      try{
        const response = await axios.get('token');
        return response.data
      }catch (error){
        console.error('Помилка при отриманні API:', error);
      }

    },
  },
  mounted() {
    this.getUserPositions();
  }
};
</script>

<style scoped>
.img-thumbnail {
  object-fit: cover;
}
</style>
