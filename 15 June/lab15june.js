
function applyDiscounts(items, itemdiscounts, offers) {
    for (let i = 0; i < items.length; i++) {
        if (offers[i]==true) {
            const discountAmount = items[i].price * (itemdiscounts[i] / 100);
            items[i].price = +(items[i].price - discountAmount);
        }
    }
    return items;
}

const items = [
    { name: "Banana", price: 350 },
    { name: "Strawberry", price: 279 },
    { name: "Apple", price: 389 },
    { name: "Melon", price: 467 }
];

const itemdiscounts = [10, 60, 30, 9]; 
const offers = [true, false, true, true];

const updatedItems = applyDiscounts(items, itemdiscounts, offers);
console.log(updatedItems);
