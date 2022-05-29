<script lang="ts">
import { defineComponent } from "vue";
import { v4 as uuidv4 } from "uuid";

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

export default defineComponent({
  props: {
    userId: {
      type: String,
      required: true,
    },
  },
  data() {
    return {
      settings: {
        id: null as string | null,
        user_id: this.userId,
        is_recurring: false,
        availabilities: [] as Availability[],
      },
      availabilityFormInputs: {
        day: defaultForm.day,
        time_interval: { ...defaultForm.time_interval },
      },
      days: [...days],
    };
  },
  watch: {
    userId(newValue) {
      this.fetchAvailabilitySettings(newValue);
    },
  },
  mounted() {
    this.fetchAvailabilitySettings(this.userId);
  },
  methods: {
    remove(index: number) {
      this.settings.availabilities.splice(index, 1);
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
            id: this.settings.id,
            user_id: this.userId,
            is_recurring: this.settings.is_recurring,
            availabilities: { ...this.settings.availabilities },
          }),
        }
      );

      if (saveResponse.status === 200) {
        alert("Success");
      }

      if (saveResponse.status === 422) {
        const response = await saveResponse.json();
        alert(response.message);
      }
    },
    addAvailability() {
      this.settings.availabilities.push({
        day: this.availabilityFormInputs.day as Day,
        time_interval: { ...this.availabilityFormInputs.time_interval },
      });

      this.availabilityFormInputs = {
        day: defaultForm.day,
        time_interval: { ...defaultForm.time_interval },
      };
    },
    async fetchAvailabilitySettings(userId: string) {
      this.settings.is_recurring = false;
      this.settings.user_id = userId;
      this.settings.availabilities = [];

      const availabilitySettingsResponse = await fetch(
        `http://localhost/api/user/${userId}/availability-settings`,
        {
          headers: { Accept: "application/json" },
        }
      );

      if (availabilitySettingsResponse.status === 404) {
        // todo generate uuid to availability form
        this.settings.id = uuidv4();

        return;
      }

      const response = await availabilitySettingsResponse.json();

      this.settings.id = response.id;
      this.settings.is_recurring = response.is_recurring;
      response.availabilities.forEach((availability: Availability) => {
        this.settings.availabilities.push(availability);
      });
    },
  },
});
</script>

<template>
  <div>
    <h2>
      Availability of <small>{{ userId }}</small>
    </h2>
    <table class="table-auto">
      <thead>
        <tr>
          <th>Nr.</th>
          <th>Day</th>
          <th>Start</th>
          <th>End</th>
          <th>Action</th>
        </tr>
      </thead>
      <tbody>
        <tr
          v-bind:key="`availability-${rowIndex}`"
          v-for="(availability, rowIndex) in settings.availabilities"
        >
          <td>{{ rowIndex }}.</td>
          <td>
            <select v-model="availability.day">
              <option
                v-bind:key="`${rowIndex}-day-${dayIndex}`"
                v-for="(day, dayIndex) in days"
                :value="day"
              >
                {{ day }}
              </option>
            </select>
          </td>
          <td>
            <input type="text" v-model="availability.time_interval.start" />
          </td>
          <td>
            <input type="text" v-model="availability.time_interval.end" />
          </td>
          <td>
            <button @click="remove(rowIndex)">Delete</button>
          </td>
        </tr>
        <tr>
          <td>NEW</td>
          <td>
            <select v-model="availabilityFormInputs.day">
              <option
                v-bind:key="`day-${day}`"
                v-for="day in days"
                :value="day"
              >
                {{ day }}
              </option>
            </select>
          </td>
          <td>
            <input
              type="text"
              v-model="availabilityFormInputs.time_interval.start"
            />
          </td>
          <td>
            <input
              type="text"
              v-model="availabilityFormInputs.time_interval.end"
            />
          </td>
          <td>
            <input
              type="button"
              @click="addAvailability"
              value="Add availability"
            />
          </td>
        </tr>
      </tbody>
    </table>

    <label for="is_recurring">
      <input type="checkbox" v-model="settings.is_recurring" id="is_recurring" />
      Is Recurring?
    </label>

    <br />
    <input type="button" @click="save" value="Save Settings" />
  </div>
</template>

<style scoped></style>
