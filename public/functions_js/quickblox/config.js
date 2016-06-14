var QBApp = {
  appId: 32059,
  authKey: 'btU26RvEO6xhK9L',
  authSecret: 'B8PypQ8UnVK2Cc9'
};

var CONFIG = {
	webrtc: {
    iceServers: [
	      {
	        'url': 'stun:stun.l.google.com:19302'
	      },
	      {
	        'url': 'turn:turnsingapore.quickblox.com:3478',
	        'username': 'quickblox',
	        'credential': 'baccb97ba2d92d71e26eb9886da5f1e0'
	      },
	      {
	        'url': 'turn:turn.quickblox.com:3478?transport=udp',
	        'username': 'quickblox',
	        'credential': 'baccb97ba2d92d71e26eb9886da5f1e0'
	      },
	      {
	        'url': 'stun:turnsingapore.quickblox.com:3478',
	        'username': 'quickblox',
	        'credential': 'baccb97ba2d92d71e26eb9886da5f1e0'
	      },
	    ]
	  },
	webrtc: {
	    answerTimeInterval: 60, // Max answer time after that the 'QB.webrtc.onUserNotAnswerListener' callback will be fired.
	    dialingTimeInterval: 2,  // The interval between call requests produced by session.call(extension)
	    disconnectTimeInterval: 30 // If an opponent lost a connection then after this time the caller will now about it via 'QB.webrtc.onSessionConnectionStateChangedListener' callback.
	},
	endpoints: {
	    api: "api.quickblox.com", // set custom API endpoint
	    chat: "chat.quickblox.com" // set custom Chat endpoint
	},
	chatProtocol: {
	    active: 2 // set 1 to use BOSH, set 2 to use WebSockets (default)
	},
	debug: {mode: 1} // set DEBUG mode
};