<template>
  <div class="max-w-6xl mx-auto p-6 space-y-8">
    <h1 class="text-4xl font-bold text-center text-gray-800">Student List</h1>
    
    <div>
    <!-- Buttons for larger screens -->
    <div class="hidden md:flex justify-between items-center mb-4 flex-col md:flex-row">
      <button 
        @click="router.push('/students/create')" 
        class="px-6 py-2 bg-green-600 text-white font-semibold rounded-lg shadow-md hover:bg-green-700 transition duration-200"
      >
        Create Student
      </button>

          <!-- Export Button -->
      <button 
        @click="exportStudents" 
        class="px-6 py-2 bg-blue-600 text-white font-semibold rounded-lg shadow-md hover:bg-blue-700 transition duration-200"
      >
        Export Students
      </button>
      
      <!-- Import Button with File Upload -->
      <label class="flex items-center px-6 py-2 bg-purple-600 text-white font-semibold rounded-lg shadow-md hover:bg-purple-700 transition duration-200 cursor-pointer">
        <span>Import Students</span>
        <input type="file" @change="importStudents" class="hidden" />
      </label>
    </div>

    <!-- Buttons for smaller screens -->
    <div class="flex flex-col space-y-4 md:hidden"> <!-- Flex column on small screens, hidden on medium and up -->
      <button 
        @click="router.push('/students/create')" 
        class="w-full px-6 py-2 bg-green-600 text-white font-semibold rounded-lg shadow-md hover:bg-green-700 transition duration-200"
      >
        Create Student
      </button>

      <button 
        @click="exportStudents" 
        class="w-full px-6 py-2 bg-blue-600 text-white font-semibold rounded-lg shadow-md hover:bg-blue-700 transition duration-200"
      >
        Export Students
      </button>

      <label class="w-full">
        <span class="block px-6 py-2 bg-purple-600 text-white font-semibold rounded-lg shadow-md hover:bg-purple-700 transition duration-200 text-center">
          Import Students
        </span>
        <input type="file" @change="importStudents" class="hidden" />
      </label>
    </div>
  </div>

    <div class="bg-white shadow-lg rounded-lg overflow-hidden">
      <div class="hidden md:block">
        <table class="min-w-full divide-y divide-gray-200">
          <thead class="bg-gray-100">
            <tr>
              <th class="px-4 py-3 text-left text-sm font-medium text-gray-700">Name</th>
              <th class="px-4 py-3 text-left text-sm font-medium text-gray-700">Grade</th>
              <th class="px-4 py-3 text-left text-sm font-medium text-gray-700">Phone Number</th>
              <th class="px-4 py-3 text-left text-sm font-medium text-gray-700">Address</th>
              <th class="px-4 py-3 text-left text-sm font-medium text-gray-700">Date of Birth</th>
              <th class="px-4 py-3 text-left text-sm font-medium text-gray-700">Actions</th>
            </tr>
          </thead>
          <tbody class="bg-white divide-y divide-gray-200">
            <tr v-for="student in students" :key="student.id" class="hover:bg-gray-50 transition duration-150">
              <td class="border px-4 py-2 text-sm">{{ student.name }}</td>
              <td class="border px-4 py-2 text-sm">{{ student.grade }}</td>
              <td class="border px-4 py-2 text-sm">{{ student.phno }}</td>
              <td class="border px-4 py-2 text-sm">{{ student.address }}</td>
              <td class="border px-4 py-2 text-sm">{{ student.date_of_birth }}</td>
              <td class="border px-4 py-2 flex space-x-2">
                <button 
                  @click="editStudent(student.id)" 
                  class="text-blue-600 bg-blue-100 hover:bg-blue-200 font-semibold py-1 px-3 rounded transition duration-200"
                >
                  Edit
                </button>
                <button 
                  @click="openDeleteModal(student)" 
                  class="text-red-600 bg-red-100 hover:bg-red-200 font-semibold py-1 px-3 rounded transition duration-200"
                >
                  Delete
                </button>
              </td>
            </tr>
          </tbody>
        </table>
      </div>

      <!-- Responsive Card Layout for Mobile -->
      <div class="md:hidden">
        <div v-for="student in students" :key="student.id" class="border-b border-gray-200 p-4">
          <h2 class="text-lg font-semibold">{{ student.name }}</h2>
          <p><strong>Grade:</strong> {{ student.grade }}</p>
          <p><strong>Phone Number:</strong> {{ student.phno }}</p>
          <p><strong>Address:</strong> {{ student.address }}</p>
          <p><strong>Date of Birth:</strong> {{ student.date_of_birth }}</p>
          <div class="flex space-x-2 mt-2">
            <button 
              @click="editStudent(student.id)" 
              class="text-blue-600 bg-blue-100 hover:bg-blue-200 font-semibold py-1 px-3 rounded transition duration-200"
            >
              Edit
            </button>
            <button 
              @click="openDeleteModal(student)"
              class="text-red-600 bg-red-100 hover:bg-red-200 font-semibold py-1 px-3 rounded transition duration-200"
            >
              Delete
            </button>
          </div>
        </div>
      </div>
    </div>

    <div class="flex justify-between mt-4 flex-col md:flex-row">
      <button 
        @click="changePage(currentPage - 1)" 
        :disabled="currentPage === 1" 
        class="bg-gray-300 px-4 py-2 rounded disabled:opacity-50"
      >
        Previous
      </button>
      <span class="self-center text-lg">Page {{ currentPage }}</span>
      <button 
        @click="changePage(currentPage + 1)" 
        :disabled="currentPage === lastPage" 
        class="bg-gray-300 px-4 py-2 rounded disabled:opacity-50"
      >
        Next
      </button>
    </div>

    <!-- Delete Confirmation Modal -->
    <DeleteConfirmModal 
      :show="isDeleteModalOpen" 
      :StudentTitle="studentToDelete?.name" 
      @confirm="deleteStudent" 
      @cancel="closeDeleteModal" 
    />
  </div>
</template>

<script setup>
import { ref, computed, onMounted } from 'vue';
import axios from '@/axios';
import { useNotificationStore } from '@/stores/notificationStore';
import { useRouter } from 'vue-router';
import DeleteConfirmModal from '@/components/DeleteConfirmModal.vue';
import { useUserStore } from '@/stores/userStore';

const userStore = useUserStore();
const notificationStore = useNotificationStore();
const students = ref([]);
const currentPage = ref(1);
const lastPage = ref(1);
const router = useRouter();
const isDeleteModalOpen = ref(false);
const studentToDelete = ref(null);

const isAdmin = computed(() => {
  const result = userStore.userRole === 'admin';
  return result;
});

onMounted(async () => {
  try {
    await userStore.fetchUserData();
  } catch (error) {
    notificationStore.error('Failed to load user data');
    console.error('Error fetching user data:', error);
  }
});

const fetchStudents = async (page = currentPage.value) => {
  try {
    const response = await axios.get(`/students?page=${page}`);
    students.value = response.data.data;
    currentPage.value = response.data.current_page;
    lastPage.value = response.data.last_page;
  } catch (error) {
    notificationStore.error('Failed to load students');
    console.error('Error fetching students:', error);
  }
};

const editStudent = (id) => {
  router.push(`/students/${id}/edit`);
};

const openDeleteModal = (student) => {
  if (!isAdmin.value) {
    notificationStore.error('You do not have permission to perform this action.'); // Show error toast
  return;
  }
  studentToDelete.value = student;
  isDeleteModalOpen.value = true;
};

const closeDeleteModal = () => {
  isDeleteModalOpen.value = false;
  studentToDelete.value = null;
};

// Delete a student
const deleteStudent = async () => {
  if (studentToDelete.value) {
    try {
      await axios.delete(`/students/${studentToDelete.value.id}`); 
      notificationStore.success('Student deleted successfully');
      fetchStudents(); // Refresh the student list
    } catch (error) {
      notificationStore.error('Failed to delete student');
      console.error('Error deleting student:', error);
    } finally {
      closeDeleteModal();
    }
  }
};

const changePage = (page) => {
  if (page >= 1 && page <= lastPage.value) {
    fetchStudents(page);
  }
};

const exportStudents = async () => {
  try {
    const response = await axios.get('/students-export', {
      responseType: 'blob',
    });

    const blob = new Blob([response.data], { type: response.headers['content-type'] });
    const link = document.createElement('a');
    link.href = window.URL.createObjectURL(blob);
    link.download = 'students.xlsx';
    link.click();

    notificationStore.success('Export successful!');
  } catch (error) {
    notificationStore.error('Export failed');
    console.error('Export error:', error);
  }
};

const importStudents = async (event) => {
  const file = event.target.files[0];
  const formData = new FormData();
  formData.append('file', file);

  try {
    await axios.post('/students-import', formData);
    notificationStore.success('Import successful!');
    fetchStudents(); 
  } catch (error) {
    notificationStore.error('Import failed');
  }
};
onMounted(fetchStudents);
</script>
