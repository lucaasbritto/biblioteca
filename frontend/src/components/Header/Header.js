import { computed } from 'vue'
import { useRouter } from 'vue-router'
import { useUserStore } from '@/stores/user'

export default function headerScript() {
  const userStore = useUserStore()
  const router = useRouter()

  const user = computed(() => userStore.user)

  function logout () {
    userStore.logout()
    router.push({ name: 'Login' })
  }

  return {
    user,
    logout
  }
}
