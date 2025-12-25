import category from './category'
import gallery from './gallery'
import state from './state'
import categoryAttributes from './category-attributes'
import categoryValue from './category-value'
import advertisement from './advertisement'

const advertisements = {
    category: Object.assign(category, category),
    gallery: Object.assign(gallery, gallery),
    state: Object.assign(state, state),
    categoryAttributes: Object.assign(categoryAttributes, categoryAttributes),
    categoryValue: Object.assign(categoryValue, categoryValue),
    advertisement: Object.assign(advertisement, advertisement),
}

export default advertisements