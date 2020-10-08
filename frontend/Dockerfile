FROM node:13.12.0-alpine as builder

WORKDIR /build
COPY . /build
RUN npm install && npm run-script build

FROM nginx:alpine

WORKDIR /app
COPY --from=builder /build/build .
