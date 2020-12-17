
export function updateArray(array, element) {
    if (array === null || array === undefined)
        return;

    let projectFound = false;
    array = array.map(elem => {
        if (element.id === elem.id) {
            projectFound = true;
            return element;
        }
        return elem;
    });
    if (!projectFound) {
        array.push(element);
    }
    return array;
}
