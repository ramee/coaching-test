<script lang="ts">
import { defineComponent } from "vue";
import AvailabilitySettings from "./AvailabilitySettings.vue";
import type { User } from "@/interface";

export default defineComponent({
  components: {
    AvailabilitySettings,
  },
  data() {
    return {
      users: [] as User[],
      selectedUser: null as User | null,
    };
  },
  methods: {
    selectUser(user: User) {
      this.selectedUser = user;
    },
    async fetchUsers() {
      const usersResponse = await fetch("http://localhost/api/user", {
        headers: { Accept: "application/json" },
      });

      const userList = await usersResponse.json();

      userList.forEach((user: User) => {
        this.users.push(user);
      });
    },
  },
  mounted() {
    this.fetchUsers();
  },
});
</script>

<template>
  <div>
    <h2>Users</h2>
    <div class="grid gap-4">
      <div class="border p-4">
        <div v-bind:key="user.name" v-for="user in users">
          <a @click="selectUser(user)">{{ user.name }}</a>
        </div>
      </div>
      <div v-if="selectedUser" class="border p-4">
        <availability-settings
          :user-id="selectedUser.id"
        ></availability-settings>
      </div>
    </div>
  </div>
</template>

<style scoped></style>
