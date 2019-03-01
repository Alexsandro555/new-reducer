export default {
  config: (state) => {
    let obj = new Object()
    obj.items="items"
    obj.load="/api/pages"
    obj.module="pages"
    obj.primary_key="id"
    obj.model="Modules\\Page\\Entities\\Page"
    return obj
  }
}