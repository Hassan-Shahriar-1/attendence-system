<template>
  <div class="p-6 space-y-6">
    <!-- Filters -->
    <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
      <div>
        <label class="font-semibold">Class</label>
        <select v-model="selectedClass" class="input" @change="loadSections">
          <option value="">Select Class</option>
          <option v-for="c in classes" :key="c.id" :value="c.id">{{ c.name }}</option>
        </select>
      </div>

      <div>
        <label class="font-semibold">Section</label>
        <select v-model="selectedSection" class="input" @change="loadStudents">
          <option value="">Select Section</option>
          <option v-for="s in sections" :key="s.id" :value="s.id">{{ s.name }}</option>
        </select>
      </div>

      <div>
        <label class="font-semibold">Date</label>
        <input type="date" v-model="attendanceDate" class="input" />
      </div>
    </div>

    <!-- Bulk Actions -->
    <div v-if="students.length > 0" class="flex gap-3 items-center">
      <span class="font-semibold text-gray-700">Bulk Action:</span>
      <button class="btn present" @click="applyBulk('Present')">Mark All Present</button>
      <button class="btn absent" @click="applyBulk('Absent')">Mark All Absent</button>
      <button class="btn late" @click="applyBulk('Late')">Mark All Late</button>
    </div>

    <!-- Student List -->
    <div v-if="students.length > 0" class="bg-white shadow rounded-xl p-4 mt-4">
      <table class="w-full table-auto">
        <thead>
          <tr class="bg-gray-100 text-left">
            <th class="p-3">Photo</th>
            <th class="p-3">Name</th>
            <th class="p-3">ID</th>
            <th class="p-3">Status</th>
          </tr>
        </thead>

        <tbody>
          <tr v-for="(student, index) in students" :key="student.id" class="border-b">
            <td class="p-3">
              <img :src="student.photo || placeholder" class="h-10 w-10 rounded-full" />
            </td>

            <td class="p-3">{{ student.name }}</td>
            <td class="p-3">{{ student.student_id }}</td>

            <td class="p-3">
              <select v-model="student.status" class="input w-40">
                <option value="Present">Present</option>
                <option value="Late">Late</option>
                <option value="Absent">Absent</option>
              </select>
            </td>
          </tr>
        </tbody>
      </table>
    </div>

    <!-- Submit Button -->
    <div v-if="students.length > 0" class="text-right mt-4">
      <button class="btn primary" @click="submitAttendance">Submit Attendance</button>
    </div>
  </div>
</template>

<script setup>
import { ref } from 'vue'
import axios from '@/axios' 

const classes = ref([])
const sections = ref([])
const students = ref([])

const selectedClass = ref('')
const selectedSection = ref('')
const attendanceDate = ref(new Date().toISOString().slice(0, 10))

const placeholder = "https://placehold.co/40x40?text=NA"

const loadClasses = async () => {
  const res = await axios.get('/grades',{ params: { per_page: 100 } })
  classes.value = res.data.data.data
}

const loadSections = async () => {
  if (!selectedClass.value) return
  const res = await axios.get(`/grades/${selectedClass.value}/sections`)
  sections.value = res.data.data
}

const loadStudents = async () => {
  if (!selectedSection.value) return
  const res = await axios.get(`/grades/${selectedClass.value}/sections/${selectedSection.value}/students`)
  students.value = res.data.data.map(s => ({
    ...s,
    status: 'Present' // default status
  }))
}

const applyBulk = (status) => {
  students.value = students.value.map(s => ({ ...s, status }))
}

const submitAttendance = async () => {
  const payload = {
    date: attendanceDate.value,
    grade_id: selectedClass.value,
    section_id: selectedSection.value,
    records: students.value.map(s => ({
      student_id: s.id,
      status: s.status
    }))
  }

  await axios.post('/attendance', payload)

  alert('Attendance Submitted!')
}

loadClasses()
</script>


