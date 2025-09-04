import api from './index'

export async function getRequests(filters = {}) {
  const response = await api.get('/books', { params: filters });
  return response.data;
}

export async function createBook(payload) {
  return await api.post('/books', payload)
}

export async function updateBook(id, payload) {
  return await api.put(`/books/${id}`, payload)
}

export async function deleteBook(id) {
  return await api.delete(`/books/${id}`)
}

export async function createAuthor(payload) {
  return await api.post("/authors", payload);
}

export async function getAuthors(filters = {}) {
  const response = await api.get("/authors", { params: filters });
  return response.data;
}

export async function updateAuthor(id, payload) {
  return await api.put(`/authors/${id}`, payload);
}

export async function deleteAuthor(id) {
  return await api.delete(`/authors/${id}`);
}

export async function getSubjects(filters = {}) {
  const response = await api.get("/subjects", { params: filters });
  return response.data;
}

export async function createSubject(payload) {
  return await api.post("/subjects", payload);
}

export async function updateSubject(id, payload) {
  return await api.put(`/subjects/${id}`, payload);
}

export async function deleteSubject(id) {
  return await api.delete(`/subjects/${id}`);
}
