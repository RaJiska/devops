FROM node:13.12.0-alpine as builder

WORKDIR /build
COPY . /build
RUN npm install

FROM node:13.12.0-alpine

WORKDIR /app
COPY --from=builder /build .

CMD [ "npm", "start" ]
