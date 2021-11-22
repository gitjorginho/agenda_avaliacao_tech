import axios from '@/axios'
const route = "contact"
export default {

    getAll() {
        return axios.get(route)
    },

    store(contact) {
        return axios.post(route, contact)
    },

    update(contact) {
        contact.append('_method','put')
        let id = contact.get('id')
        return axios.post(route + '/' + id, contact)
    },

    destroy(stage) {
        return axios.delete(route + '/' + stage.id)
    },

}
