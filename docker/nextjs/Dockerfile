# Node.jsベースイメージ
FROM node:22.15.0-slim

# 作業ディレクトリを作成
WORKDIR /app

RUN npx create-next-app@latest my-app --typescript --eslint --tailwind --no-src-dir --app --no-turbopack --import-alias "@/*"

#COPY ./package*.json /app/

# 依存関係をインストール
#RUN npm install

# アプリディレクトリに移動
WORKDIR /app/my-app


# アプリコードをコピー
#COPY ./my-portfolio /app

#WORKDIR /app/my-app
# サーバー起動コマンド
#CMD ["npm", "run","dev"]
