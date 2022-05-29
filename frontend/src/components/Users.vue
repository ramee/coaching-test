<script lang="ts">
import { defineComponent } from "vue";

type Day =
  | "Monday"
  | "Tuesday"
  | "Wednesday"
  | "Thursday"
  | "Friday"
  | "Saturday"
  | "Sunday";

interface Availability {
  day: Day;
  time_interval: {
    start: string;
    end: string;
  };
}

interface User {
  id: string;
  name: string;
  availabilities: Availability[];
}

const defaultForm = {
  day: "Monday",
  time_interval: {
    start: "00:00",
    end: "23:59",
  },
};

const days = [
  "Monday",
  "Tuesday",
  "Wednesday",
  "Thursday",
  "Friday",
  "Saturday",
  "Sunday",
];

export default defineComponent({
  data() {
    return {
      users: [] as User[],
      selectedUser: null as User | null,
      availabilities: [],
      settingsId: null as string | null,
      isRecurring: false,
      availabilityFormInputs: { ...defaultForm },
      days: [...days],
    };
  },
  methods: {
    selectUser(user: User) {
      this.selectedUser = user;

      this.fetchAvailabilitySettings(user.id);
    },
    async save() {
      const saveResponse = await fetch(
        `http://localhost/api/user/availability-settings`,
        {
          method: "POST",
          headers: {
            Accept: "application/json",
            "Content-Type": "application/json",
          },
          body: JSON.stringify({
            id: this.settingsId,
            user_id: this.selectedUser?.id,
            is_recurring: this.isRecurring,
            availabilities: { ...this.selectedUser?.availabilities },
          }),
        }
      );

      if (saveResponse.status === 200) {
        alert("Success");
      }
    },
    addAvailability() {
      this.selectedUser?.availabilities.push({
        day: this.availabilityFormInputs.day as Day,
        time_interval: this.availabilityFormInputs.time_interval,
      });

      this.availabilityFormInputs = { ...defaultForm };
    },
    async fetchAvailabilitySettings(userId: string) {
      const availabilitySettingsResponse = await fetch(
        `http://localhost/api/user/${userId}/availability-settings`,
        {
          headers: { Accept: "application/json" },
        }
      );

      if (availabilitySettingsResponse.status === 404) {
        // todo generate uuid to availability form
        this.settingsId = "dkdkdkdkdd";
        return;
      }

      const response = await availabilitySettingsResponse.json();

      this.settingsId = response.id;
      const user = this.users.find((user) => user.id === userId);
      if (user) {
        user.availabilities = [];
        response.availabilities.forEach((availability: Availability) => {
          user.availabilities.push(availability);
        });
      }
    },
  },
  async mounted() {
    const usersResponse = await fetch("http://localhost/api/user", {
      headers: { Accept: "application/json" },
    });

    const userList = await usersResponse.json();

    userList.forEach((user: User) => {
      this.users.push(user);
    });
  },
});
</script>

<template>
  <div>
    <h2>Users</h2>
    <div v-bind:key="user.name" v-for="user in users">
      <a @click="selectUser(user)">{{ user.name }}</a>
    </div>
    <div v-if="selectedUser">
      <h2>
        Availability of <small>{{ selectedUser.name }}</small>
      </h2>
      <div
        v-bind:key="`availability-${index}`"
        v-for="(availability, index) in selectedUser.availabilities"
      >
        {{ availability.day }} {{ availability.time_interval.start }}
        {{ availability.time_interval.end }}
      </div>
      <div>
        <fieldset>
          <legend>Add new</legend>
          <select v-model="availabilityFormInputs.day">
            <option v-bind:key="`day-${day}`" v-for="day in days" :value="day">
              {{ day }}
            </option>
          </select>
          <input
            type="text"
            v-model="availabilityFormInputs.time_interval.start"
          />
          <input
            type="text"
            v-model="availabilityFormInputs.time_interval.end"
          />
          <input
            type="button"
            @click="addAvailability"
            value="Add availability"
          />
        </fieldset>

        <label for="is_recurring">Is Recurring?</label>
        <input type="checkbox" v-model="isRecurring" id="is_recurring" />
        <br />
        <input type="button" @click="save" value="Save Settings" />
      </div>
    </div>
  </div>
</template>

<style scoped>
a {
  cursor: pointer;
  text-decoration: underline;
}
</style>
