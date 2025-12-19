import ListPermissions from './ListPermissions'
import CreatePermission from './CreatePermission'
import EditPermission from './EditPermission'
import ViewPermission from './ViewPermission'

const Pages = {
    ListPermissions: Object.assign(ListPermissions, ListPermissions),
    CreatePermission: Object.assign(CreatePermission, CreatePermission),
    EditPermission: Object.assign(EditPermission, EditPermission),
    ViewPermission: Object.assign(ViewPermission, ViewPermission),
}

export default Pages