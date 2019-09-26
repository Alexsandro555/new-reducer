export default {
  config: (state) => {
    let obj = new Object()
    obj.items="items"
    obj.load="/api/file_list_views"
    obj.module="file_list_views"
    obj.primary_key="id"
    obj.model="Modules\\Files\\Entities\\FileListView"
    return obj
  },
  items: state => state.items
}