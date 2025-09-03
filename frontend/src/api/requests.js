import api from './index'

export async function getRequests(filters = {}) {
  const response = await api.get('/books', { params: filters });
  return response.data;
}