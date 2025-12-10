import ListRoles from './ListRoles'
import CreateRole from './CreateRole'
import EditRole from './EditRole'
import ViewRole from './ViewRole'

const Pages = {
    ListRoles: Object.assign(ListRoles, ListRoles),
    CreateRole: Object.assign(CreateRole, CreateRole),
    EditRole: Object.assign(EditRole, EditRole),
    ViewRole: Object.assign(ViewRole, ViewRole),
}

export default Pages