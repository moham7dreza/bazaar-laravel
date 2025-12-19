import PermissionResource from './PermissionResource'
import RoleResource from './RoleResource'

const Resources = {
    PermissionResource: Object.assign(PermissionResource, PermissionResource),
    RoleResource: Object.assign(RoleResource, RoleResource),
}

export default Resources