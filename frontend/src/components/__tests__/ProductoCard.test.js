import { mount } from '@vue/test-utils'
import { describe, it, expect } from 'vitest'
import ProductoCard from '@/components/ProductoCard.vue'

const producto = {
  id: 1,
  nombre: 'Teclado Mecánico',
  precio: 59.99,
  stock: 5,
  descripcion: 'Teclado con switches azules'
}

describe('ProductoCard', () => {

  it('muestra el nombre del producto', () => {
    const wrapper = mount(ProductoCard, { props: { producto } })
    expect(wrapper.text()).toContain('Teclado Mecánico')
  })

  it('muestra el precio del producto', () => {
    const wrapper = mount(ProductoCard, { props: { producto } })
    expect(wrapper.text()).toContain('59.99')
  })

  it('muestra el stock del producto', () => {
    const wrapper = mount(ProductoCard, { props: { producto } })
    expect(wrapper.text()).toContain('Stock: 5')
  })

  it('muestra la descripción si existe', () => {
    const wrapper = mount(ProductoCard, { props: { producto } })
    expect(wrapper.text()).toContain('Teclado con switches azules')
  })

  it('no muestra descripción si no viene en props', () => {
    const sinDescripcion = { ...producto, descripcion: null }
    const wrapper = mount(ProductoCard, { props: { producto: sinDescripcion } })
    expect(wrapper.find('.descripcion').exists()).toBe(false)
  })

  it('emite agregar-carrito al hacer click en el botón', async () => {
    const wrapper = mount(ProductoCard, { props: { producto } })
    await wrapper.find('[data-test="btn-agregar"]').trigger('click')
    expect(wrapper.emitted('agregar-carrito')).toBeTruthy()
    expect(wrapper.emitted('agregar-carrito')[0]).toEqual([producto])
  })

})