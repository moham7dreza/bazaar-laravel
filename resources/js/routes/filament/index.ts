import exports from './exports'
import imports from './imports'
import superAdmin from './super-admin'

const filament = {
    exports: Object.assign(exports, exports),
    imports: Object.assign(imports, imports),
    superAdmin: Object.assign(superAdmin, superAdmin),
}

export default filament