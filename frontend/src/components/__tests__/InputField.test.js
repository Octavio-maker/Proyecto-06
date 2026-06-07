import { mount } from '@vue/test-utils'
import { describe, it, expect } from 'vitest'
import InputField from '@/components/InputField.vue'

describe('InputField', () => {

  it('muestra el label correcto', () => {
    const wrapper = mount(InputField, {
      props: { label: 'Nombre', name: 'nombre', modelValue: '' }
    })
    expect(wrapper.text()).toContain('Nombre')
  })

  it('muestra el mensaje de error si se pasa error prop', () => {
    const wrapper = mount(InputField, {
      props: {
        label: 'Precio',
        name: 'precio',
        modelValue: '',
        error: 'El precio es obligatorio'
      }
    })
    expect(wrapper.text()).toContain('El precio es obligatorio')
  })

  it('no muestra mensaje de error si no hay error', () => {
    const wrapper = mount(InputField, {
      props: { label: 'Stock', name: 'stock', modelValue: '', error: null }
    })
    expect(wrapper.find('.error-msg').exists()).toBe(false)
  })

  it('emite update:modelValue al escribir', async () => {
    const wrapper = mount(InputField, {
      props: { label: 'Nombre', name: 'nombre', modelValue: '' }
    })
    await wrapper.find('input').setValue('nuevo valor')
    expect(wrapper.emitted('update:modelValue')).toBeTruthy()
  })

  it('agrega clase input-error cuando hay error', () => {
    const wrapper = mount(InputField, {
      props: {
        label: 'Nombre',
        name: 'nombre',
        modelValue: '',
        error: 'Campo requerido'
      }
    })
    expect(wrapper.find('input').classes()).toContain('input-error')
  })

})