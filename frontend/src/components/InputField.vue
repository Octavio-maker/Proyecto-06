<script setup>
defineProps({
  label: String,
  name: String,
  modelValue: [String, Number],
  error: String,
  type: {
    type: String,
    default: 'text'
  },
  placeholder: String,
})

defineEmits(['update:modelValue'])
</script>

<template>
  <div class="campo">
    <label :for="name">{{ label }}</label>
    <input
      :id="name"
      :name="name"
      :type="type"
      :placeholder="placeholder"
      :value="modelValue"
      :class="{ 'input-error': error }"
      @input="$emit('update:modelValue', $event.target.value)"
    />
    <span class="error-msg" v-if="error">{{ error }}</span>
  </div>
</template>

<style scoped>
.campo {
  display: flex;
  flex-direction: column;
  gap: 4px;
  margin-bottom: 16px;
}

label {
  font-weight: 600;
  font-size: 0.9rem;
}

input {
  padding: 8px 12px;
  border: 1px solid #ccc;
  border-radius: 6px;
  font-size: 1rem;
  transition: border-color 0.2s;
}

input:focus {
  outline: none;
  border-color: #4f46e5;
}

input.input-error {
  border-color: #ef4444;
}

.error-msg {
  color: #ef4444;
  font-size: 0.8rem;
}
</style>