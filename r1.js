// 2019-01-01 00:00:00
let startTimestamp = 1546275600_000;

const data = {
    indexByTs: {},
    indexByUser: {},
};

function getRandomPoint() {
    const min = -30;
    const max = 30;
    return Math.floor(Math.random() * (max - min + 1)) + min;
}

function generateUsername() {
    const charSet = 'ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz0123456789';
    const maxLen = 10;
    const minLen = 6;
    let length = Math.floor(Math.random() * (maxLen - minLen + 1)) + minLen;
    let result = '';

    for (let i = 0; i < length; i++) {
        let randomIndex = Math.floor(Math.random() * charSet.length);
        result += charSet.charAt(randomIndex);
    }

    return result;
}

const users = [];

while (users.length < 200) {
    const str = generateUsername();
    if (users.includes(str)) {
        continue;
    }

    users.push(str);
}


function pickRandomValue(array) {
    return array[Math.floor(Math.random() * array.length)];
}

const batchSize = 10000; // Number of records to generate in each batch
const totalRecords = 50000000; // Total number of records to generate

function generateBatch(batchIndex) {
    const batch = [];

    for (let j = 0; j < batchSize; j++) {
        const newData = {
            ts: startTimestamp + batchIndex + j,
            user: pickRandomValue(users),
            point: getRandomPoint(),
        };

        batch.push(newData);
    }

    return Promise.resolve(batch);
}

function processBatch(batch) {
    // build index by ts
    batch.forEach((newData) => {
        data.indexByTs[newData.ts] ??= [];
        data.indexByTs[newData.ts].push(newData);

        data.indexByUser[newData.user] ??= [];
        data.indexByUser[newData.user].push(newData);
    });

    return batch.length; // Return the number of processed records
}

async function generateRecords() {
    console.log('Building 50M records... Will take a little while.');

    const start = Date.now();

    const promises = [];

    for (let i = 0; i < totalRecords; i += batchSize) {
        promises.push(
            generateBatch(i)
                .then(processBatch)
        );
    }

    console.log('Total Jobs to process concurrently:', promises.length)

    await Promise.all(promises);

    const end = Date.now();

    console.log('Generation complete.');

    console.log(`Took: ${((end - start) / 1000)}s`);
}

function findByTimestamp(ts) {
    return data.indexByTs[ts] || null;
}

function findByUser(ts) {
    return data.indexByUser[ts] || null;
}

function calculateTotalPointsAndPrint() {
    console.log('Total points of all users');
    Object.keys(data.indexByUser)
        .forEach((user) => {
            const points = (data.indexByUser[user] || [])
                .reduce((total, tnx) => {
                    total += tnx.point;

                    return total;
                }, 0);

            console.log(`User ${user} - Points: ${points}`);
        });
}

function calculateTotalPointsAndPrintByDate(startDate, endDate) {
    const tsStart = (new Date(startDate)).getTime();
    const tsEnd = (new Date(endDate)).getTime();
    console.log(tsStart, tsEnd);
    const userPointMap = {};

    for (let i = tsStart; i <= tsEnd; i++) {
        const items = data.indexByTs[i] || [];

        for (const item of items) {
            userPointMap[item.user] ??= 0;
            userPointMap[item.user] += item.point;
        }
    }

    console.log(`From ${startDate} to ${endDate}, here is the list:`)
    for (const [user, points] of Object.entries(userPointMap)) {
        console.log(`User ${user} - Points: ${points}`);
    }
};

async function withTimeLogger(callback, actionName) {
    const start = Date.now();

    await callback();

    const end = Date.now();

    console.log(`${actionName} took: ${((end - start) / 1000)}s`);
}

(async () => {
    // R1
    await withTimeLogger(generateRecords, 'Generate 50M records');

    // R2
    await withTimeLogger(() => {
        const timestamp = 1546275610262;
        console.log('Find by timestamp result:')
        console.log(findByTimestamp(timestamp));
        console.log('Find by non-exist timestamp result:')
        console.log(findByTimestamp(9999999));
    }, 'Find by Timestamp (ok and null)');

    // R3
    await withTimeLogger(() => {
        const user = pickRandomValue(users);
        console.log('Find by user result:')
        console.log('Total records found', findByUser(user).length);
        console.log('Find by non-exist user result:')
        console.log(findByUser('https://github.com/sethsandaru'));
    }, 'Find by user (ok and null)');

    // R4
    await withTimeLogger(() => {
        calculateTotalPointsAndPrint();
    }, 'Calculate total points of 200 users');

    // R5
    await withTimeLogger(() => {
        const startDate = '2019-01-01';
        const endDate = '2019-01-03';
        calculateTotalPointsAndPrintByDate(startDate, endDate);
    }, 'Calculate total points between 2 dates');
})();