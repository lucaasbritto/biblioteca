<template>
  <q-drawer show-if-above side="left" :width="220" class="side-menu">    
    <div class="q-pt-md q-pl-xs drawer-header">
      <q-icon name="dashboard" size="18px" />
      <span class="drawer-title">Dashboard</span>
    </div>

    <div class="q-pt-md menu-container">
      <div class="section-title">
        <q-icon name="menu_book" size="12px" class="section-icon" />
        Livros
      </div>
      <q-item clickable v-ripple to="/" exact active-class="menu-item-active" dense>
        <q-item-section avatar>
          <q-icon name="library_books" size="14px" />
        </q-item-section>
        <q-item-section>Listar Livros</q-item-section>
      </q-item>
      
        <q-item clickable v-ripple to="/books/new" exact active-class="menu-item-active" dense>
          <q-item-section avatar>
            <q-icon name="post_add" size="14px" />
          </q-item-section>
          <q-item-section>Novo Livro</q-item-section>
        </q-item>
      

      <div class="section-title">
        <q-icon name="person" size="12px" class="section-icon" />
        Autores
      </div>
      <q-item clickable v-ripple to="/authors" exact active-class="menu-item-active" dense>
        <q-item-section avatar>
          <q-icon name="group" size="14px" />
        </q-item-section>
        <q-item-section>Listar Autores</q-item-section>
      </q-item>
      
        <q-item clickable v-ripple to="/authors/new" exact active-class="menu-item-active" dense>
          <q-item-section avatar>
            <q-icon name="person_add" size="14px" />
          </q-item-section>
          <q-item-section>Novo Autor</q-item-section>
        </q-item>
      

      <div class="section-title">
        <q-icon name="category" size="12px" class="section-icon" />
        Assuntos
      </div>
      <q-item clickable v-ripple to="/subjects" exact active-class="menu-item-active" dense>
        <q-item-section avatar>
          <q-icon name="label" size="14px" />
        </q-item-section>
        <q-item-section>Listar Assuntos</q-item-section>
      </q-item>      
        <q-item clickable v-ripple to="/subjects/new" exact active-class="menu-item-active" dense>
          <q-item-section avatar>
            <q-icon name="post_add" size="14px" />
          </q-item-section>
          <q-item-section>Novo Assunto</q-item-section>
        </q-item>      
    </div>

  </q-drawer>
</template>

<script setup>
</script>

<style scoped lang="scss">
@use './SideMenu.scss'; 
</style>
