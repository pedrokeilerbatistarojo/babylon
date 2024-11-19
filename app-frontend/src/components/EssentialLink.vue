<template>
  <q-item
    class="q-pa-md"
    clickable
    :to="props.link"
    v-ripple
    active-class="active-link"
  >
    <q-item-section
      v-if="props.icon"
      avatar
    >
      <q-icon size="md" :name="props.icon" />
    </q-item-section>

    <q-item-section>
      <q-item-label class="fw-bold font-size-16">{{ props.title }}</q-item-label>
      <q-item-label class="font-size-16" caption style="color: #918e8e">{{ props.caption }}</q-item-label>
    </q-item-section>
  </q-item>
</template>

<script setup>
defineOptions({
  name: 'EssentialLink'
})

const props = defineProps({
  title: {
    type: String,
    required: true
  },

  caption: {
    type: String,
    default: ''
  },

  link: {
    type: String,
    default: '#'
  },

  icon: {
    type: String,
    default: ''
  }
})
</script>

<style scoped>
.active-link{
  background-color: #200f4b;
  color: #9AFF6E;
}
</style>

